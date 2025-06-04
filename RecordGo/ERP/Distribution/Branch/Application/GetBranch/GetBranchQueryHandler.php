<?php
declare(strict_types=1);


namespace Distribution\Branch\Application\GetBranch;


use Distribution\Branch\Domain\BranchCollection;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\Branch\Domain\BranchCriteria;
class GetBranchQueryHandler
{
    /**
     * @var BranchRepository
     */
    private BranchRepository $branchRepository;

    /**
     * GetBranchQueryHandler constructor.
     * @param BranchRepository $branchRepository
     */
    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }
    /**
     * @param GetBranchHandler $getBranchHandler
     * @return GetBranchQueryHandlerResponse
     */
    public function handle(GetBranchHandler $getBranchHandler): GetBranchQueryHandlerResponse
    {
        $response =  $this->branchRepository->getBy(new BranchCriteria());

        return new GetBranchQueryHandlerResponse(new BranchCollection($response->getData()), $response->getTotalRows());
    }
}