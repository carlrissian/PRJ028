<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\DeleteVehicleMovement;

use Distribution\Movement\Domain\MovementRepository;

class DeleteVehicleMovementCommandHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @param DeleteVehicleMovementCommand $command
     * @return DeleteVehicleMovementResponse
     */
    final public function handle(DeleteVehicleMovementCommand $command): DeleteVehicleMovementResponse
    {
        $movement = $this->movementRepository->getById($command->getMovementId());

        $vehicleLineCollection = $movement->getVehicleLineCollection();

        // Eliminamos de la request las líneas canceladas, para evitar que el WS interprete que estamos intentando asignar un vehículo que ya ha sido eliminado.
        foreach ($vehicleLineCollection as $line) {
            if ($line->getVehicleDelete()) {
                $vehicleLineCollection->removeByObject($line);
            }
        }

        foreach ($command->getVehicleIdList() as $vehicleId) {
            $vehicleLineCollection->removeByProperty($vehicleId, ['vehicle', 'id']);
        }

        $movement->setVehicleLineCollection($vehicleLineCollection);

        $response = $this->movementRepository->update($movement);

        return new DeleteVehicleMovementResponse(
            $response->getId(),
            $response->getOperationResponse()->wasSuccess(),
            $response->getOperationResponse()->getCode(),
            $response->getOperationResponse()->getMessage()
        );
    }
}
