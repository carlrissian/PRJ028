<?php

namespace Distribution\LocationType\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\LocationType\Domain\LocationTypeCriteria;
use Distribution\LocationType\Domain\LocationTypeRepository;

class SelectListLocationTypeQueryHandler
{
    /**
     * @var LocationTypeRepository
     */
    private $locationTypeRepository;

    /**
     * SelectListLocationTypeQueryHandler constructor.
     *
     * @param LocationTypeRepository $locationTypeRepository
     */
    public function __construct(LocationTypeRepository $locationTypeRepository)
    {
        $this->locationTypeRepository = $locationTypeRepository;
    }

    /**
     * @return SelectListLocationTypeResponse
     */
    public function handle(): SelectListLocationTypeResponse
    {
        $locationTypeCollection = $this->locationTypeRepository->getBy(new LocationTypeCriteria())->getCollection();
        return new SelectListLocationTypeResponse(Utils::createSelect($locationTypeCollection));
    }
}
