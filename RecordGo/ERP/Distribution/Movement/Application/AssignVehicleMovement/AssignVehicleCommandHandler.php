<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\AssignVehicleMovement;

use Distribution\Movement\Domain\VehicleLine;
use Shared\Domain\ValueObject\FloatValueObject;
use Distribution\Movement\Domain\VehicleRecords;
use Distribution\Movement\Domain\Vehicle\Vehicle;
use Distribution\Movement\Domain\MovementRepository;
use Distribution\Movement\Domain\Vehicle\VehicleStatus;
use Distribution\Movement\Domain\VehicleLineCollection;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Shared\Domain\Exception\NotFoundInCollectionException;

class AssignVehicleCommandHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * AssignVehicleCommandHandler constrcutor.
     *
     * @param MovementRepository $movementRepository
     */
    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @param AssignVehicleCommand $command
     * @return AssignVehicleResponse
     */
    public function handle(AssignVehicleCommand $command): AssignVehicleResponse
    {
        $movement = $this->movementRepository->getById($command->getMovementId());

        // Comprobamos si el usuario a mandado más vehículos de los permitidos para el tipo de transporte.
        if (
            $movement->getMovementType()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER')) &&
            $movement->getTransportMethod()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTMETHOD_ROAD')) &&
            $movement->getAssignedLicensePlateUnits()->getTotal() + $command->getVehiclesUnits() > 10
        ) {
            return new AssignVehicleResponse(false, "Cannot assign more than 10 vehicles to this movement");
        }

        $vehicleLineCollection = $movement->getVehicleLineCollection() ?? new VehicleLineCollection([]);

        // Eliminamos de la request las líneas canceladas, para evitar que el WS interprete que estamos intentando asignar un vehículo que ya ha sido eliminado.
        foreach ($vehicleLineCollection as $line) {
            if ($line->getVehicleDelete()) {
                $vehicleLineCollection->removeByObject($line);
            }
        }

        foreach ($command->getVehiclesId() as $vehicle) {
            try {
                $vehicleLine = $vehicleLineCollection->getByProperty(intval($vehicle['id']), ['vehicle', 'id']);
                if ($vehicleLine) {
                    return new AssignVehicleResponse(false, "Vehicle {$vehicle['licensePlate']} / {$vehicle['vin']} already assigned");
                }
            } catch (NotFoundInCollectionException $e) {
            }

            $vehicleLineCollection->add(
                new VehicleLine(
                    new Vehicle(
                        intval($vehicle['id']),
                        $vehicle['licensePlate'] ?? null,
                        $vehicle['vin'] ?? null,
                        new VehicleStatus(intval($vehicle['vehicleStatusId']))
                    ),
                    null,
                    null,
                    new VehicleRecords(
                        isset($vehicle['actualKms']) && is_numeric($vehicle['actualKms']) ? intval($vehicle['actualKms']) : null,
                        isset($vehicle['actualBattery']) && is_numeric($vehicle['actualBattery']) ? FloatValueObject::create(floatval($vehicle['actualBattery'])) : null,
                        isset($vehicle['actualOctaves']) && is_numeric($vehicle['actualOctaves']) ? intval($vehicle['actualOctaves']) : null
                    )
                )
            );
        }

        $movement->setVehicleLineCollection($vehicleLineCollection);
        if ($command->getVehiclesUnits() > $movement->getVehicleUnits()) $movement->setVehicleUnits($command->getVehiclesUnits());

        $movementOperationResponse = $this->movementRepository->update($movement);

        $success = $movementOperationResponse->getOperationResponse()->wasSuccess();
        return new AssignVehicleResponse($success, $movementOperationResponse->getOperationResponse()->getMessage());
    }
}
