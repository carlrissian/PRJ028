<?php

namespace Distribution\Branch\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Branch\Domain\BranchRepository;

class SelectListBranchQueryHandler
{
    /**
     * @var BranchRepository
     */
    private $branchRepository;

    /**
     * SelectListBranchQueryHandler constructor.
     *
     * @param BranchRepository $branchRepository
     */
    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    /**
     * @return SelectListBranchResponse
     */
    public function handle(): SelectListBranchResponse
    {
        $branchCollection = $this->branchRepository->getBy(new BranchCriteria())->getCollection();
        return new SelectListBranchResponse(Utils::createCustomSelectList($branchCollection, 'id', 'name', 'branchIATA', 'branchGroupId'));
    }
}
