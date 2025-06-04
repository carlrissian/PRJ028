<?php

namespace Distribution\MovementCategory\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\MovementCategory\Domain\MovementCategoryCriteria;
use Distribution\MovementCategory\Domain\MovementCategoryRepository;

class SelectListMovementCategoryQueryHandler
{
    /**
     * @var MovementCategoryRepository
     */
    private $movementCategoryRepository;

    /**
     * SelectListMovementCategoryQueryHandler constructor.
     *
     * @param MovementCategoryRepository $movementCategoryRepository
     */
    public function __construct(MovementCategoryRepository $movementCategoryRepository)
    {
        $this->movementCategoryRepository = $movementCategoryRepository;
    }

    /**
     * @return SelectListMovementCategoryResponse
     */
    public function handle(): SelectListMovementCategoryResponse
    {
        $movementCategoryCollection = $this->movementCategoryRepository->getBy(new MovementCategoryCriteria())->getCollection();
        return new SelectListMovementCategoryResponse(Utils::createSelect($movementCategoryCollection));
    }
}
