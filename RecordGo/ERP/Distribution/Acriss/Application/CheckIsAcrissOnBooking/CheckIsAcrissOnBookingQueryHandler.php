<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\CheckIsAcrissOnBooking;


use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;


/**
 * Class EditAcrissCommandHandler
 * @package Distribution\Acriss\Application\CheckIsAcrissOnBooking
 */
class CheckIsAcrissOnBookingQueryHandler
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


    public function handle(CheckIsAcrissOnBookingQuery $query): CheckIsAcrissOnBookingResponse
    {
        $acrissCriteria = new AcrissCriteria(new FilterCollection([new Filter('ID', new FilterOperator(FilterOperator::EQUAL), $query->getAcrissId())]));
        $isAcrissOnBooking = $this->acrissRepository->checkIsOnBooking($acrissCriteria);

        return new CheckIsAcrissOnBookingResponse($isAcrissOnBooking);
    }

}
