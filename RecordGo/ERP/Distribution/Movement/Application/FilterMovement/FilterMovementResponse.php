<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\FilterMovement;

class FilterMovementResponse
{
    /**
     * @var array
     */
    private array $movementResponse;

    /**
     * FilterMovementResponse constructor.
     * 
     * @param array $movementResponse
     */
    public function __construct(array $movementResponse)
    {
        $this->movementResponse = $movementResponse;
    }

    /**
     * @return array
     */
    public function getMovementResponse(): array
    {
        return $this->movementResponse;
    }
}
