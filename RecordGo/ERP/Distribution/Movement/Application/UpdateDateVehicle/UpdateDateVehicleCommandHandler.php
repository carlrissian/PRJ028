<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\UpdateDateVehicle;

use Distribution\Movement\Domain\VehicleLine;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\Movement\Domain\MovementRepository;
use Shared\Domain\Exception\NotFoundInCollectionException;

class UpdateDateVehicleCommandHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * UpdateDateVehicleCommandHandler constructor.
     *
     * @param MovementRepository $movementRepository
     */
    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @param UpdateDateVehicleCommand $command
     * @return UpdateDateVehicleResponse
     * 
     * @throws NotFoundInCollectionException
     */
    public function handle(UpdateDateVehicleCommand $command): UpdateDateVehicleResponse
    {
        $actualLoadDate = $command->getActualLoadDate();
        $actualUnloadDate = $command->getActualUnLoadDate();

        $movement = $this->movementRepository->getById($command->getMovementId());

        $vehicleLineCollection = $movement->getVehicleLineCollection();

        // Eliminamos de la request las líneas canceladas, para evitar que el WS interprete que estamos intentando asignar un vehículo que ya ha sido eliminado.
        foreach ($vehicleLineCollection as $line) {
            if ($line->getVehicleDelete()) {
                $vehicleLineCollection->removeByObject($line);
            }
        }

        foreach ($command->getVehicleIdList() as $vehicleId) {
            try {
                $vehicleLine = $vehicleLineCollection->getByProperty($vehicleId, ['vehicle', 'id']);

                $newVehicleLine = new VehicleLine(
                    $vehicleLine->getVehicle(),
                    !empty($actualLoadDate) ? DateTimeValueObject::createFromString($actualLoadDate) : $vehicleLine->getActualLoadDate(),
                    !empty($actualUnloadDate) ? DateTimeValueObject::createFromString($actualUnloadDate) : $vehicleLine->getActualUnloadDate(),
                    $vehicleLine->getVehicleRecordsLoad(),
                    $vehicleLine->getVehicleRecordsUnload(),
                    $vehicleLine->getVehicleMaintenanceEndDate(),
                    $vehicleLine->getVehicleDelete()
                );

                $vehicleLineCollection->replaceItem($vehicleLine, $newVehicleLine);
            } catch (NotFoundInCollectionException $e) {
                return new UpdateDateVehicleResponse(false);
            }
        }

        $movement->setVehicleLineCollection($vehicleLineCollection);


        $response = $this->movementRepository->update($movement);

        return new UpdateDateVehicleResponse($response->getOperationResponse()->wasSuccess());
    }
}
