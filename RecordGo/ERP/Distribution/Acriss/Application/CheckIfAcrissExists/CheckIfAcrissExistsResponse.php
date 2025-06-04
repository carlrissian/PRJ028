<?php

namespace Distribution\Acriss\Application\CheckIfAcrissExists;

class CheckIfAcrissExistsResponse
{
    /**
     * @var bool
     */
    private $acrissExists;

    /**
     * CheckIfAcrissExistsResponse constructor.
     *
     * @param boolean $acrissExists
     */
    public function __construct(bool $acrissExists)
    {
        $this->acrissExists = $acrissExists;
    }

    /**
     * @return bool
     */
    public function acrissExists(): bool
    {
        return $this->acrissExists;
    }
}
