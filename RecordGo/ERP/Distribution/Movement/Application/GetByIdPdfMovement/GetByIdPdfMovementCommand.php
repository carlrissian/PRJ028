<?php
declare(strict_types=1);


namespace Distribution\Movement\Application\GetByIdPdfMovement;


class GetByIdPdfMovementCommand
{
    /**
     * @var int
     */
    private int $movementId;

    /**
     * GetByIdPdfMovementCommand constructor.
     * @param int $movementId
     */
    public function __construct(int $movementId)
    {
        $this->movementId = $movementId;
    }

    /**
     * @return int
     */
    public function getMovementId(): int
    {
        return $this->movementId;
    }

}