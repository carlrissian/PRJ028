<?php

namespace Distribution\GearBox\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\GearBox\Domain\GearBoxCriteria;
use Distribution\GearBox\Domain\GearBoxRepository;

class SelectListGearBoxQueryHandler
{
    /**
     * @var GearBoxRepository
     */
    private $gearBoxRepository;

    /**
     * SelectListGearBoxQueryHandler constructor.
     *
     * @param GearBoxRepository $gearBoxRepository
     */
    public function __construct(GearBoxRepository $gearBoxRepository)
    {
        $this->gearBoxRepository = $gearBoxRepository;
    }

    /**
     * @return SelectListGearBoxResponse
     */
    public function handle(): SelectListGearBoxResponse
    {
        $gearBoxCollection = $this->gearBoxRepository->getBy(new GearBoxCriteria())->getCollection();
        return new SelectListGearBoxResponse(Utils::createSelectWithFormattedName($gearBoxCollection, 'id', 'name', 'acrissLetter', [], 'name'));
    }
}
