<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

interface MovementRepository
{
    /**
     * @param MovementCriteria $criteria
     * @return MovementGetByResponse
     */
    public function getBy(MovementCriteria $criteria): MovementGetByResponse;

    /**
     * @param MovementCriteria $criteria
     * @return ListVehicleGetByResponse
     */
    public function getByVehicles(MovementCriteria $criteria): ListVehicleGetByResponse;

    /**
     * @param integer $movementId
     * @param MovementCriteria $criteria
     * @return VehicleLineGetByResponse
     */
    public function getAssignedVehicles(int $movementId, MovementCriteria $criteria): VehicleLineGetByResponse;

    /**
     * @param integer $id
     * @return Movement
     */
    public function getById(int $id): Movement;

    /**
     * @param Movement $movement
     * @return MovementOperationResponse
     */
    public function store(Movement $movement): MovementOperationResponse;

    /**
     * @param Movement $movement
     * @return MovementOperationResponse
     */
    public function update(Movement $movement): MovementOperationResponse;
}
