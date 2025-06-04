<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\IndexVehicle;


class IndexVehicleResponse
{
    /**
     * @var array
     */
    private array $selectList;

    /**
     * @param array $selectList
     */
    public function __construct(array $selectList)
    {
        $this->selectList = $selectList;
    }

    /**
     * @return array
     */
    public function getSelectList(): array
    {
        return $this->selectList;
    }
}
