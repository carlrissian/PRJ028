<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\EditMovement;

class EditMovementQuery
{
    /**
     * @var int
     */
    private int $id;

    /**
     * EditMovementQuery constructor.
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
    public function getId(): int
    {
        return $this->id;
    }
}
