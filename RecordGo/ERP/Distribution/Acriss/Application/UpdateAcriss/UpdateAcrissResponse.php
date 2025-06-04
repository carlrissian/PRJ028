<?php

declare(strict_types=1);

namespace Distribution\Acriss\Application\UpdateAcriss;

class UpdateAcrissResponse
{
    /**
     * @var bool
     */
    private bool $acrissUpdated;

    /**
     * @var bool
     */
    private bool $branchTranslationsUpdated;

    /**
     * UpdateAcrissResponse constructor.
     *
     * @param boolean $acrissUpdated
     * @param boolean $branchTranslationsUpdated
     */
    public function __construct(
        bool $acrissUpdated,
        bool $branchTranslationsUpdated
    ) {
        $this->acrissUpdated = $acrissUpdated;
        $this->branchTranslationsUpdated = $branchTranslationsUpdated;
    }

    /**
     * @return bool
     */
    public function isAcrissUpdated(): bool
    {
        return $this->acrissUpdated;
    }

    /**
     * @return bool
     */
    public function areBranchTranslationsUpdated(): bool
    {
        return $this->branchTranslationsUpdated;
    }
}
