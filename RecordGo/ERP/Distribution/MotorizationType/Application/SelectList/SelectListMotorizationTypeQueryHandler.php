<?php

namespace Distribution\MotorizationType\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\MotorizationType\Domain\MotorizationTypeCriteria;
use Distribution\MotorizationType\Domain\MotorizationTypeRepository;

class SelectListMotorizationTypeQueryHandler
{
    /**
     * @var MotorizationTypeRepository
     */
    private $motorizationTypeRepository;

    /**
     * SelectListMotorizationTypeQueryHandler constructor.
     *
     * @param MotorizationTypeRepository $motorizationTypeRepository
     */
    public function __construct(MotorizationTypeRepository $motorizationTypeRepository)
    {
        $this->motorizationTypeRepository = $motorizationTypeRepository;
    }

    /**
     * @return SelectListMotorizationTypeResponse
     */
    public function handle(): SelectListMotorizationTypeResponse
    {
        $motorizationTypeCollection = $this->motorizationTypeRepository->getBy(new MotorizationTypeCriteria())->getCollection();
        return new SelectListMotorizationTypeResponse(Utils::createSelectWithFormattedName($motorizationTypeCollection, 'id', 'name', 'acrissLetter', [], 'name'));
    }
}
