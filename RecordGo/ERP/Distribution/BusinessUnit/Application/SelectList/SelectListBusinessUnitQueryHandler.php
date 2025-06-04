<?php

namespace Distribution\BusinessUnit\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\BusinessUnit\Domain\BusinessUnitCriteria;
use Distribution\BusinessUnit\Domain\BusinessUnitRepository;

class SelectListBusinessUnitQueryHandler
{
    /**
     * @var BusinessUnitRepository
     */
    private $businessUnitRepository;

    /**
     * SelectListBusinessUnitQueryHandler constructor.
     *
     * @param BusinessUnitRepository $businessUnitRepository
     */
    public function __construct(BusinessUnitRepository $businessUnitRepository)
    {
        $this->businessUnitRepository = $businessUnitRepository;
    }

    /**
     * @return SelectListBusinessUnitResponse
     */
    public function handle(): SelectListBusinessUnitResponse
    {
        $businessUnitCollection = $this->businessUnitRepository->getBy(new BusinessUnitCriteria())->getCollection();
        return new SelectListBusinessUnitResponse(Utils::createSelect($businessUnitCollection));
    }
}
