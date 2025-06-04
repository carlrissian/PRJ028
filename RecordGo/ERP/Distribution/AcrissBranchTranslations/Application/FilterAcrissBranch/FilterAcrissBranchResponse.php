<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Application\FilterAcrissBranch;

class FilterAcrissBranchResponse
{
    /**
     * @var array
     */
    private array $branchArray;

    /**
     * @param $BranchArray
     */
    public function __construct($BranchArray)
    {
        $this->branchArray = $BranchArray;
    }

    /**
     * @return array
     */
    public function getBranchArray(): array
    {
        return $this->branchArray;
    }
}
