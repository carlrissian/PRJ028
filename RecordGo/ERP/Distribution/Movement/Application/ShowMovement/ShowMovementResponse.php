<?php
declare(strict_types=1);


namespace Distribution\Movement\Application\ShowMovement;


class ShowMovementResponse
{
    /**
     * @var int
     */
    private int $movementTypeId;
    /**
     * @var array
     */
    private array $movement;

    /**
     * ShowMovementResponse constructor.
     * @param int $movementTypeId
     * @param array $movement
     */
    public function __construct(int $movementTypeId, array $movement)
    {
        $this->movementTypeId = $movementTypeId;
        $this->movement = $movement;
    }

    /**
     * @return int
     */
    public function getMovementTypeId(): int
    {
        return $this->movementTypeId;
    }

    /**
     * @return array
     */
    public function getMovement(): array
    {
        return $this->movement;
    }

}