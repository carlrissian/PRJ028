<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\EditMovement;

class EditMovementResponse
{
    /**
     * @var int
     */
    private $movementTypeId;

    /**
     * @var array
     */
    private $movement;

    /**
     * @var array
     */
    private $selectList;

    /**
     * EditMovementResponse constructor.
     *
     * @param integer $movementTypeId
     * @param array $movement
     * @param array $selectList
     */
    public function __construct(
        int $movementTypeId,
        array $movement,
        array $selectList
    ) {
        $this->movementTypeId = $movementTypeId;
        $this->movement = $movement;
        $this->selectList = $selectList;
    }

    /**
     * Get the value of movementTypeId
     *
     * @return int
     */
    public function getMovementTypeId(): int
    {
        return $this->movementTypeId;
    }

    /**
     * Get the value of movement
     *
     * @return array
     */
    public function getMovement(): array
    {
        return $this->movement;
    }

    /**
     * Get the value of selectList
     *
     * @return array
     */
    public function getSelectList(): array
    {
        return $this->selectList;
    }
}
