<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\GetAutomaticCost;

class GetAutomaticCostResponse
{
    /**
     * @var float|null
     */
    private ?float $automaticCost;

    /**
     * GetAutomaticCostResponse constructor.
     * @param float|null $automaticCost
     */
    public function __construct(float $automaticCost = null)
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
