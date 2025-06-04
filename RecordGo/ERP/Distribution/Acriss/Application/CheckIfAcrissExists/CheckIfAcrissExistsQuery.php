<?php

namespace Distribution\Acriss\Application\CheckIfAcrissExists;

class CheckIfAcrissExistsQuery
{
    /**
     * @var string
     */
    private $acriss;

    /**
     * CheckIfAcrissExistsQuery constructor.
     *
     * @param string $acriss
     */
    public function __construct(string $acriss)
    {
        $this->acriss = $acriss;
    }

    /**
     * @return string
     */
    public function getAcriss(): string
    {
        return $this->acriss;
    }
}
