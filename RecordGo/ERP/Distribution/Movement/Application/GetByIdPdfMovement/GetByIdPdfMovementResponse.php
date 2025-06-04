<?php
declare(strict_types=1);


namespace Distribution\Movement\Application\GetByIdPdfMovement;


class GetByIdPdfMovementResponse
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
     * GetByIdPdfMovementResponse constructor.
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