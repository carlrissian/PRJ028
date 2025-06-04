<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

use Shared\Domain\OperationResponse;

class MovementOperationResponse
{

    /**
     * @var int|null
     */
    private ?int $id;
    /**
     * @var OperationResponse
     */
    private OperationResponse $operationResponse;

    /**
     * MovementType constructor.
     * 
     * @param int|null $id
     * @param OperationResponse $operationResponse
     */
    public function __construct(?int $id, OperationResponse $operationResponse)
    {
        $this->id = $id;
        $this->operationResponse = $operationResponse;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return OperationResponse
     */
    public function getOperationResponse(): OperationResponse
    {
        return $this->operationResponse;
    }
}
