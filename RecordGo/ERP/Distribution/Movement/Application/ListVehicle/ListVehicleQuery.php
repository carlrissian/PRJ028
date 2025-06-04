<?php
declare(strict_types=1);


namespace Distribution\Movement\Application\ListVehicle;


class ListVehicleQuery
{

    /**
     * @var int
     */
    private int $id;

    /**
     * ListVehicleQuery constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}