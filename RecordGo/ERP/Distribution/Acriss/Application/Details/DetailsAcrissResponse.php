<?php

namespace Distribution\Acriss\Application\Details;

class DetailsAcrissResponse
{
    /**
     * @var object
     */
    private object $acriss;

    /**
     * @var array
     */
    private array $branchTranslations;

    /**
     * @param array $acriss
     */
    public function __construct(object $acriss, array $branchTranslations)
    {
        $this->acriss = $acriss;
        $this->branchTranslations = $branchTranslations;
    }

    /**
     * @return object
     */
    public function getAcriss(): object
    {
        return $this->acriss;
    }

    /**
     * @return array
     */
    public function getBranchTranslations(): array
    {
        return $this->branchTranslations;
    }
}
