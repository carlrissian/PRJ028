<?php

namespace Distribution\MovementStatus\Application\Filter;

use Shared\Utils\Utils;
use Distribution\MovementStatus\Domain\MovementStatusCriteria;
use Distribution\MovementStatus\Domain\MovementStatusRepository;

class FilterMovementStatusQueryHandler
{
    /**
     * @var MovementStatusRepository
     */
    private MovementStatusRepository $movementStatusRepository;

    /**
     * FilterMovementStatusQueryHandler constructor.
     *
     * @param MovementStatusRepository $movementStatusRepository
     */
    public function __construct(MovementStatusRepository $movementStatusRepository)
    {
        $this->movementStatusRepository = $movementStatusRepository;
    }

    public function handle(): FilterMovementStatusResponse
    {
        $criteria = new MovementStatusCriteria();
        $movementStatusCollection = $this->movementStatusRepository->getBy($criteria)->getCollection();

        $movementStatusArray = Utils::createSelect($movementStatusCollection);

        return new FilterMovementStatusResponse($movementStatusArray);
    }
}
