<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\FilterStopSale;

use Exception;
use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Distribution\Acriss\Domain\Acriss;
use Shared\Domain\Pagination\Pagination;
use Distribution\StopSale\Domain\StopSale;
use Shared\Domain\Criteria\FilterOperator;
use Distribution\StopSale\Domain\Department;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\StopSale\Domain\StopSaleCriteria;
use Distribution\StopSale\Domain\StopSaleRepository;
use Shared\Constants\Infrastructure\ConstantsJsonFile;

class FilterStopSaleQueryHandler
{
    /**
     * @var StopSaleRepository
     */
    private StopSaleRepository $stopSaleRepository;

    /**
     * FilterStopSaleQueryHandler constructor.
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
    public function handle(FilterStopSaleQuery $query)
    {
        $stopSaleCriteria = $this->setCriteria($query);
        [$stopSaleCollection, $totalRows] = $this->stopSaleRepository->getBy($stopSaleCriteria)->toArray();

        $stopSaleList = [];
        /**
         * @var StopSale $stopSale
         */
        foreach ($stopSaleCollection as $stopSale) {
            $stopSaleCategory = $stopSale->getCategory() ? $stopSale->getCategory()->getId() : null;

            // $partners = [];
            // if ($stopSaleCategory === intval(ConstantsJsonFile::getValue('STOPSALECAT_ONEWAY'))) {
            //     $partners = $stopSale->getPartners()->toArray();
            // }

            $carGroupIds = [];
            $carGroupList = [];
            foreach ($stopSale->getAcriss() as $acriss) {
                /**
                 * @var Acriss $acriss
                 */
                if ($acriss->getCarGroup() != null && !in_array($acriss->getCarGroup()->getId(), $carGroupIds)) {
                    $carGroupIds[] = $acriss->getCarGroup()->getId();
                    $carGroupList[] = [
                        'id' => $acriss->getCarGroup()->getId(),
                        'name' => $acriss->getCarGroup()->getName()
                    ];
                }
            }
            usort($carGroupList, function ($a, $b) {
                return strcasecmp($a['name'], $b['name']);
            });

            $acrissList = $stopSale->getAcriss()->toArray();
            usort($acrissList, function ($a, $b) {
                return strcasecmp($a->getName(), $b->getName());
            });

            $recordWord = 'Record';
            $partnerList = $stopSale->getPartners()->toArray();
            usort($partnerList, function ($a, $b) use ($recordWord) {
                $aName = $a->getName();
                $bName = $b->getName();

                if (strpos($aName, $recordWord) !== false && strpos($bName, $recordWord) === false) {
                    return -1;
                } elseif (strpos($aName, $recordWord) === false && strpos($bName, $recordWord) !== false) {
                    return 1;
                } else {
                    return strcasecmp($aName, $bName);
                }
            });

            $sellCodeList = $stopSale->getSellCodes()->toArray();
            usort($sellCodeList, function ($a, $b) {
                return strcasecmp($a->getName(), $b->getName());
            });

            $productList = $stopSale->getProducts()->toArray();
            usort($productList, function ($a, $b) {
                return strcasecmp($a->getName(), $b->getName());
            });


            $stopSaleList[] = [
                'id' => $stopSale->getId(),
                'department' => $stopSale->getDepartment(),
                'stopSaleCategoryId' => $stopSaleCategory,
                'stopSaleType' => $stopSale->getStopSaleType()->getName(),
                'initDate' => $stopSale->getInitDate(),
                'endDate' => $stopSale->getEndDate(),
                'acriss' => $acrissList,
                'carGroups' => $carGroupList,
                'regionPickUp' => $stopSale->getRegionPickUp(),
                'areaPickUp' => $stopSale->getAreaPickUp(),
                'branchPickUp' => $stopSale->getBranchPickUp(),
                'regionDropOff' => $stopSale->getRegionDropOff(),
                'areaDropOff' => $stopSale->getAreaDropOff(),
                'branchDropOff' => $stopSale->getBranchDropOff(),
                // 'partners' => $partners,
                'partners' => $stopSale->getPartners(),
                'sellCodes' => $sellCodeList,
                'products' => $productList,
                'startTime' => ($stopSale->getStartTime() != null) ? $stopSale->getStartTime()->getTime() : null,
                'endTime' => ($stopSale->getEndTime()) ? $stopSale->getEndTime()->getTime() : null,
                'recurrence' => $stopSale->getRecurrence(),
                'minDaysRent' => $stopSale->getMinDaysRent(),
                'maxDaysRent' => $stopSale->getMaxDaysRent(),
                'connectedVehicle' => $stopSale->isConnectedVehicle(),
                'active' => !$stopSale->isCancelled(),
                'cancelled' => $stopSale->isCancelled(),
                'creationUser' => ($stopSale->getCreationUser()) ? $stopSale->getCreationUser()->getName() : null,
                'creationDate' => $stopSale->getCreationDate(),
                'canBeEditCancel' => $stopSale->getDepartment()->getId() === Department::DISTRIBUTION && $this->canBeEditCancel(
                    $stopSale->isCancelled(),
                    ($stopSale->getInitDate()) ? $stopSale->getInitDate()->getValue()->getTimestamp() : null,
                    ($stopSale->getEndDate()) ? $stopSale->getEndDate()->getValue()->getTimestamp() : null
                ),
            ];
        }

        $stopSaleResponse['total'] = $totalRows;
        $stopSaleResponse['rows'] = $stopSaleList;

        return new FilterStopSaleResponse($stopSaleResponse);
    }


    /**
     * @param FilterStopSaleQuery $query
     * @return StopSaleCriteria
     */
    private function setCriteria(FilterStopSaleQuery $query): StopSaleCriteria
    {
        $filterCollection = new FilterCollection([]);

        if ($query->getDepartmentId()) $filterCollection->add(new Filter('DEPARTMENTIDS', new FilterOperator(FilterOperator::IN), $query->getDepartmentId()));

        if ($query->getCategoryId()) $filterCollection->add(new Filter('STOPSALECATID', new FilterOperator(FilterOperator::EQUAL), $query->getCategoryId()));

        if ($query->getInitDate()) $filterCollection->add(new Filter('DATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getInitDate())));

        if ($query->getEndDate()) $filterCollection->add(new Filter('DATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getEndDate())));

        if ($query->getAcrissId()) $filterCollection->add(new Filter('ACRISSIDS', new FilterOperator(FilterOperator::IN), $query->getAcrissId()));

        // if ($query->getRegionPickUpId()) $filterCollection->add(new Filter('PICKUPREGIONIDIN', new FilterOperator(FilterOperator::IN), $query->getRegionPickUpId()));

        // if ($query->getRegionDropOffId()) $filterCollection->add(new Filter('DROPOFFREGIONIDIN', new FilterOperator(FilterOperator::IN), $query->getRegionDropOffId()));

        // if ($query->getAreaPickUpId()) $filterCollection->add(new Filter('PICKUPAREAIDIN', new FilterOperator(FilterOperator::IN), $query->getAreaPickUpId()));

        // if ($query->getAreaDropOffId()) $filterCollection->add(new Filter('DROPOFFAREAIDIN', new FilterOperator(FilterOperator::IN), $query->getAreaDropOffId()));

        if ($query->getBranchPickUpId()) $filterCollection->add(new Filter('BRANCHIDS', new FilterOperator(FilterOperator::IN), $query->getBranchPickUpId()));

        // if ($query->getBranchDropOffId()) $filterCollection->add(new Filter('DROPOFFBRANCHIDIN', new FilterOperator(FilterOperator::IN), $query->getBranchDropOffId()));

        if ($query->getPartnersId()) $filterCollection->add(new Filter('PARTNERSIDS', new FilterOperator(FilterOperator::IN), $query->getPartnersId()));

        if ($query->getSellCodesId()) $filterCollection->add(new Filter('SELLCODEIDS', new FilterOperator(FilterOperator::IN), $query->getSellCodesId()));

        if ($query->getProductsId()) $filterCollection->add(new Filter('PRODUCTIDS', new FilterOperator(FilterOperator::IN), $query->getProductsId()));

        if ($query->getStopSaleTypeId()) $filterCollection->add(new Filter('STOPSALETYPEIDS', new FilterOperator(FilterOperator::IN), $query->getStopSaleTypeId()));

        if ($query->getStopSaleStatusId()) $filterCollection->add(new Filter('STATUS', new FilterOperator(FilterOperator::EQUAL), $query->getStopSaleStatusId()));

        // if ($query->getConnectedVehicle()) $filterCollection->add(new Filter('CONECTEDVEHICLE', new FilterOperator(FilterOperator::EQUAL), $query->getConnectedVehicle()));

        if ($query->getCreationDateFrom()) $filterCollection->add(new Filter('CREATIONDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getCreationDateFrom())));

        if ($query->getCreationDateTo()) $filterCollection->add(new Filter('CREATIONDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getCreationDateTo())));


        $sortCollection = null;
        if (!empty($query->getSort()) && !empty($query->getOrder())) {
            // Reglas para transformar los valores de sort
            $sort = $query->getSort();
            if ($sort === 'DEPARTMENT') {
                $sort = 'DEPARTMENTNAME';
            }
            if ($sort === 'STOPSALETYPE') {
                $sort = 'STOPSALETYPENAME';
            }
            if ($sort === 'BRANCHPICKUP') {
                $sort = 'BRANCHINTNAME';
            }
            // Crear la colección de ordenación con el valor transformado
            $sortCollection = new SortCollection([
                new Sort($sort, $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);

        return new StopSaleCriteria($filterCollection, $pagination);
    }

    private function canBeEditCancel(?bool $statusCancelled, ?int $startDate, ?int $endDate): bool
    {
        $result = false;

        if ($statusCancelled !== true) {
            $actualDate = strtotime(date('Y-m-d'));
            if ($endDate && $startDate) {
                $result = ($actualDate <= $startDate) || ($actualDate <= $endDate);
            } else {
                $result = ($actualDate <= $startDate);
            }
        }

        return $result;
    }
}
