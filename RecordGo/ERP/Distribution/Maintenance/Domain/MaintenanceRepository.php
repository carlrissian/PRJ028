<?php
declare(strict_types=1);


namespace Distribution\Maintenance\Domain;


interface MaintenanceRepository
{
    /**
     * @param int $id
     * @return Maintenance
     */
    public function getById(int $id): Maintenance;
}