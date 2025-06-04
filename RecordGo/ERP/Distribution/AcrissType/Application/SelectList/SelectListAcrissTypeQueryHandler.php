<?php

namespace Distribution\AcrissType\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\AcrissType\Domain\AcrissTypeCriteria;
use Distribution\AcrissType\Domain\AcrissTypeRepository;

class SelectListAcrissTypeQueryHandler
{
    /**
     * @var AcrissTypeRepository
     */
    private $acrissTypeRepository;

    /**
     * SelectListAcrissTypeQueryHandler constructor.
     *
     * @param AcrissTypeRepository $acrissTypeRepository
     */
    public function __construct(AcrissTypeRepository $acrissTypeRepository)
    {
        $this->acrissTypeRepository = $acrissTypeRepository;
    }

    /**
     * @return SelectListAcrissTypeResponse
     */
    public function handle(): SelectListAcrissTypeResponse
    {
        $acrissTypeCollection = $this->acrissTypeRepository->getBy(new AcrissTypeCriteria())->getCollection();
        return new SelectListAcrissTypeResponse(Utils::createSelectWithFormattedName($acrissTypeCollection, 'id', 'name', 'acrissLetter', [], 'name'));
    }
}
