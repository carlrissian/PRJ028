<?php

namespace Distribution\StopSale\Application\ListHistoryStopSale;

use Exception;
use Distribution\StopSale\Domain\Acriss;
use Distribution\StopSale\Domain\StopSale;
use Distribution\StopSale\Domain\StopSaleRepository;

final class ListHistoryStopSaleQueryHandler
{
    /**
     * @var StopSaleRepository
     */
    private StopSaleRepository $stopSaleRepository;

    /**
     * GetByIdHistoryStopSellHandler constructor.
     * 
     * @param StopSaleRepository $stopSaleRepository
     */
    public function __construct(StopSaleRepository $stopSaleRepository)
    {
        $this->stopSaleRepository = $stopSaleRepository;
    }

    /**
     * @throws Exception
     */
    public function handle(ListHistoryStopSaleQuery $listHistoryStopSaleQuery): ListHistoryStopSaleResponse
    {
        [$stopSaleHistoryCollection, $totalRows] = $this->stopSaleRepository->getStopSaleHistoryById($listHistoryStopSaleQuery->getStopSaleId())->toArray();

        $stopSaleHistoryList = [];

        /**
         * @var StopSale $stopSaleHistory
         */
        foreach ($stopSaleHistoryCollection as $stopSaleHistory) {

            $carGroupNames = [];
            foreach ($stopSaleHistory->getAcriss() as $acriss) {
                /**
                 * @var Acriss $acriss
                 */
                if ($acriss->getCarGroup() != null) {
                    $carGroupNames[] = $acriss->getCarGroup()->getName();
                }
            }
            $carGroupList = implode(', ', $carGroupNames);

            $stopSaleHistoryList[] = [
                'id' => $stopSaleHistory->getId(),
                'department' => $stopSaleHistory->getDepartment() ? $stopSaleHistory->getDepartment()->getName() : null,
                'stopSaleType' => $stopSaleHistory->getStopSaleType()->getName(),
                'recurrence' => $stopSaleHistory->getRecurrence() ? $stopSaleHistory->getRecurrence()->toArray() : null,
                'initDate' => $stopSaleHistory->getInitDate(),
                'endDate' => $stopSaleHistory->getEndDate(),
                'connectedVehicle' => $stopSaleHistory->isConnectedVehicle(),
                'pickUpRegion' => $stopSaleHistory->getPickUpRegion() ? $stopSaleHistory->getPickUpRegion()->toArray() : null,
                'pickUpArea' => $stopSaleHistory->getPickUpArea() ? $stopSaleHistory->getPickUpArea()->toArray() : null,
                'pickUpBranch' => $stopSaleHistory->getPickUpBranch() ? $stopSaleHistory->getPickUpBranch()->toArray() : null,
                'dropOffRegion' => $stopSaleHistory->getDropOffRegion() ? $stopSaleHistory->getDropOffRegion()->toArray() : null,
                'dropOffArea' => $stopSaleHistory->getDropOffArea() ? $stopSaleHistory->getDropOffArea()->toArray() : null,
                'dropOffBranch' => $stopSaleHistory->getDropOffBranch() ? $stopSaleHistory->getDropOffBranch()->toArray() : null,
                'partners' => $stopSaleHistory->getPartners(),
                'sellCodes' => $stopSaleHistory->getSellCodes(),
                'products' => $stopSaleHistory->getProducts(),
                'acriss' => $stopSaleHistory->getAcriss(),
                'carGroups' => $carGroupList,
                'startTime' => ($stopSaleHistory->getStartTime()) ? $stopSaleHistory->getStartTime()->getTime() : null,
                'endTime' => ($stopSaleHistory->getEndTime()) ? $stopSaleHistory->getEndTime()->getTime() : null,
                'minDaysRent' => $stopSaleHistory->getMinDaysRent(),
                'maxDaysRent' => $stopSaleHistory->getMaxDaysRent(),
                'creationDate' => $stopSaleHistory->getCreationDate(),
                'creationUser' => ($stopSaleHistory->getCreationUser()) ? $stopSaleHistory->getCreationUser()->getName() : null,
                'cancellationDate' => $stopSaleHistory->getCancellationDate(),
                'cancellationUser' => ($stopSaleHistory->getCancellationUser()) ? $stopSaleHistory->getCancellationUser()->getName() : null,
                // 'stopSaleStatus' => $stopSaleHistory->getStopSaleStatus()->getName()
            ];
        }

        return new ListHistoryStopSaleResponse($stopSaleHistoryList, $totalRows);
    }
}
