<?php

namespace Distribution\Location\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\Location\Domain\LocationCriteria;
use Distribution\Location\Domain\LocationRepository;

class SelectListLocationQueryHandler
{
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * SelectListLocationQueryHandler constructor.
     *
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @return SelectListLocationResponse
     */
    public function handle(): SelectListLocationResponse
    {
        $locationCollection = $this->locationRepository->getBy(new LocationCriteria())->getCollection();
        return new SelectListLocationResponse(Utils::createSelect($locationCollection));
    }
}
