<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

use Shared\Domain\OperationResponse;

interface VehicleRepository
{
    /**
     * @param VehicleCriteria $vehicleCriteria
     * @return VehicleGetByResponse
     */
    public function getBy(VehicleCriteria $vehicleCriteria): VehicleGetByResponse;

    /**
     * @param int $id
     * @return Vehicle
     */
    public function getById(int $id): ?Vehicle;

    /**
     * @param VehicleHistoryCriteria $historyCriteria
     * @return VehicleHistoryGetByResponse
     */
    public function getVehicleHistoryBy(VehicleHistoryCriteria $historyCriteria): VehicleHistoryGetByResponse;

    /**
     * @param VehiclesToUpdateCriteria $criteria
     * @return VehicleToUpdateCollection
     */
    public function getVehiclesToUpdateBy(VehiclesToUpdateCriteria $criteria): VehicleToUpdateCollection;

    /**
     * @param VehicleToAssignCriteria $criteria
     * @return VehicleGetByResponse|OperationResponse
     */
    public function getVehiclesToAssignBy(VehicleToAssignCriteria $criteria);

    /**
     * @param int $vehicleId
     * @return VehicleAnticipationsGetByResponse
     */
    public function getVehicleAnticipationsByVehicleId(int $vehicleId): VehicleAnticipationsGetByResponse;

    /**
     * @param Vehicle $vehicle
     * @return int|null
     */
    public function update(Vehicle $vehicle): ?int;
}
