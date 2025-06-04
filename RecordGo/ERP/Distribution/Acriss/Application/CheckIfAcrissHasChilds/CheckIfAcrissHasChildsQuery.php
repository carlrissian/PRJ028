<?php

namespace Distribution\Acriss\Application\CheckIfAcrissHasChilds;

class CheckIfAcrissHasChildsQuery
{
    /**
     * @var string
     */
    private $acrissFirstLetter;

    /**
     * @var string
     */
    private $acrissSecondLetter;

    /**
     * @var string
     */
    private $acrissThirdLetter;

    /**
     * CheckIfAcrissHasChildsQuery constructor.
     *
     * @param string $acrissFirstLetter
     * @param string $acrissSecondLetter
     * @param string $acrissThirdLetter
     */
    public function __construct(
        string $acrissFirstLetter,
        string $acrissSecondLetter,
        string $acrissThirdLetter
    ) {
        $this->acrissFirstLetter = $acrissFirstLetter;
        $this->acrissSecondLetter = $acrissSecondLetter;
        $this->acrissThirdLetter = $acrissThirdLetter;
    }

    /**
     * @return string
     */
    public function getAcrissFirstLetter(): string
    {
        return $this->acrissFirstLetter;
    }

    /**
     * @return string
     */
    public function getAcrissSecondLetter(): string
    {
        return $this->acrissSecondLetter;
    }

    /**
     * @return string
     */
    public function getAcrissThirdLetter(): string
    {
        return $this->acrissThirdLetter;
    }
}
