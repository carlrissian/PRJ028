<?php

namespace Distribution\SellCode\Domain;

class Commissionable
{
    /**
     * @var float|null
     */
    private $start;

    /**
     * @var float|null
     */
    private $end;

    /**
     * Commissionable constructor.
     * 
     * @param int|null $start
     * @param int|null $end
     */
    public function __construct(?float $start = null, ?float $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return float|null
     */
    public function getStart(): ?float
    {
        return $this->start;
    }

    /**
     * @return float|null
     */
    public function getEnd(): ?float
    {
        return $this->end;
    }


    /**
     * @param array $commissionableArray
     * @return self
     */
    public static function createFromArray(array $commissionableArray): self
    {
        return new self(
            isset($commissionableArray['COMMISION']) ? floatval($commissionableArray['COMMISION']) : null,
            isset($commissionableArray['COMMISIONTO']) ? floatval($commissionableArray['COMMISIONTO']) : null,
        );
    }
}
