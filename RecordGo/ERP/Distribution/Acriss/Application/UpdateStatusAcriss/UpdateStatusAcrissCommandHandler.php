<?php

declare(strict_types=1);

namespace Distribution\Acriss\Application\UpdateStatusAcriss;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissRepository;

/**
 * Class StoreAcrissCommandHandler
 * @package Distribution\Acriss\Application\StoreAcriss
 */
class UpdateStatusAcrissCommandHandler
{
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * @param AcrissRepository $acrissRepository
     */
    public function __construct(AcrissRepository $acrissRepository)
    {
        $this->acrissRepository = $acrissRepository;
    }


    /**
     * @param UpdateStatusAcrissCommand $command
     * @return UpdateStatusAcrissResponse
     */
    final public function handle(UpdateStatusAcrissCommand $command): UpdateStatusAcrissResponse
    {
        $acrissCriteria = new AcrissCriteria(new FilterCollection([new Filter('ID', new FilterOperator(FilterOperator::EQUAL), $command->getAcrissId())]));
        $isOnBooking = $this->acrissRepository->checkIsOnBooking($acrissCriteria);
        if ($isOnBooking) {
            return new UpdateStatusAcrissResponse(false, $isOnBooking);
        }

        $acriss = $this->acrissRepository->getById($command->getAcrissId());
        $acriss->setEnabled($command->isEnabled());
        $acrissUpdated = $this->acrissRepository->update($acriss);

        return new UpdateStatusAcrissResponse($acrissUpdated ? true : false, $isOnBooking);
    }
}
