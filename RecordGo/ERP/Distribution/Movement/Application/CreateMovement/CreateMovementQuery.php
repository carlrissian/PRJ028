<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\CreateMovement;

class CreateMovementQuery
{
    /**
     * @var int
     */
    private int $id;

    /**
     * CreateMovementQuery constructor.
     * 
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getMovementTypeId(): int
    {
        return $this->id;
    }
}
