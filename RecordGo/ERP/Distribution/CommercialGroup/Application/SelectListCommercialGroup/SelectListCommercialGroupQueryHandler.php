<?php

namespace Distribution\CommercialGroup\Application\SelectListCommercialGroup;

use Shared\Utils\Utils;
use Distribution\CommercialGroup\Domain\CommercialGroupCriteria;
use Distribution\CommercialGroup\Domain\CommercialGroupRepository;

class SelectListCommercialGroupQueryHandler
{
    /**
     * @var CommercialGroupRepository
     */
    private CommercialGroupRepository $commercialGroupRepository;

    /**
     * @param CommercialGroupRepository $commercialGroupRepository
     */
    public function __construct(CommercialGroupRepository $commercialGroupRepository)
    {
        $this->commercialGroupRepository = $commercialGroupRepository;
    }

    /**
     * @return SelectListCommercialGroupResponse
     */
    public function handle(): SelectListCommercialGroupResponse
    {
        $response = $this->commercialGroupRepository->getBy(new CommercialGroupCriteria());

        $commercialGroupCollection = $this->commercialGroupRepository->getBy(new CommercialGroupCriteria())->getCollection();
        return new SelectListCommercialGroupResponse(Utils::createSelect($commercialGroupCollection));
    }
}
