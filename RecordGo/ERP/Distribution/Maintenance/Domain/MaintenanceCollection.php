<?php
declare(strict_types=1);


namespace Distribution\Maintenance\Domain;


use Shared\Domain\Collection;

class MaintenanceCollection extends Collection
{

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Maintenance::class;
    }
}