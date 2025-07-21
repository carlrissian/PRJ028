<?php

namespace Distribution\CarClass\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\CarClass\Domain\CarClassCriteria;
use Distribution\CarClass\Domain\CarClassRepository;

class SelectListCarClassQueryHandler
{
    /**
     * @var CarClassRepository
     */
    private $carClassRepository;

    /**
     * SelectListCarClassQueryHandler constructor.
     *
     * @param CarClassRepository $carClassRepository
     */
    public function __construct(CarClassRepository $carClassRepository)
    {
        $this->carClassRepository = $carClassRepository;
    }

    /**
     * @return SelectListCarClassResponse
     */
    public function handle(): SelectListCarClassResponse
    {
        $carClassCollection = $this->carClassRepository->getBy(new CarClassCriteria())->getCollection();
        return new SelectListCarClassResponse(Utils::createCustomSelectList($carClassCollection, 'id', 'name', 'acrissLetter'));
    }
}
