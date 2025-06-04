<?php

declare(strict_types=1);

namespace Distribution\Route\Domain;

class RouteGetByAutomaticCostResponse
{

    /**
     * @var float|null
     */
    private ?float $automaticCost;

    /**
     * RouteGetByResponse constructor.
     * 
     * @param float|null $automaticCost
     */
    public function __construct(?float $automaticCost = null)
    {
        $this->automaticCost = $automaticCost;
    }

    /**
     * @return float|null
     */
    public function getAutomaticCost(): ?float
    {
        return $this->automaticCost;
    }
}
