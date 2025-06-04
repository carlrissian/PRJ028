<?php

namespace Distribution\Acriss\Application\CheckIfAcrissHasChilds;

class CheckIfAcrissHasChildsResponse
{
    /**
     * @var bool
     */
    private $acrissHasChilds;

    /**
     * CheckIfAcrissHasChildsResponse constructor.
     *
     * @param boolean $acrissHasChilds
     */
    public function __construct(bool $acrissHasChilds)
    {
        $this->acrissHasChilds = $acrissHasChilds;
    }

    /**
     * @return bool
     */
    public function acrissHasChilds(): bool
    {
        return $this->acrissHasChilds;
    }
}
