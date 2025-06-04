<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Application\FilterParameterSettings;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Shared\Domain\ValueObject\DateValueObject;
use Distribution\ParameterSetting\Domain\Acriss;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\ParameterSetting\Domain\ParameterSetting;
use Distribution\ParameterSetting\Domain\ParameterSettingCriteria;
use Distribution\ParameterSetting\Domain\ParameterSettingRepository;

class FilterParameterSettingsQueryHandler
{
    /**
     * @var ParameterSettingRepository
     */
    private ParameterSettingRepository $parameterSettingRepository;

    /**
     * GetParameterSettingsHandler constructor.
     * 
     * @param ParameterSettingRepository $parameterSettingRepository
     */
    public function __construct(ParameterSettingRepository $parameterSettingRepository)
    {
        $this->parameterSettingRepository = $parameterSettingRepository;
    }
    /**
     * @param FilterParameterSettingsQuery $query
     * @return FilterParameterSettingsResponse
     */
    public function handle(FilterParameterSettingsQuery $query): FilterParameterSettingsResponse
    {
        [$parameterSettingCollection, $totalRows] = $this->parameterSettingRepository->getBy($this->setCriteria($query))->toArray();

        $parameterSettingList = [];
        /**
         * @var ParameterSetting $parameterSetting
         */
        foreach ($parameterSettingCollection as $parameterSetting) {
            $carGroupNames = [];
            if ($parameterSetting->getAcrissCollection()) {
                /**
                 * @var Acriss $acriss
                 */
                foreach ($parameterSetting->getAcrissCollection() as $acriss) {
                    if ($acriss->getVehicleGroupName() != null && !in_array($acriss->getVehicleGroupName(), $carGroupNames)) {
                        $carGroupNames[] = $acriss->getVehicleGroupName();
                    }
                }

            }

            $replacementCarGroupNames = [];
            if ($parameterSetting->getReplacementAcrissCollection()) {
                /**
                 * @var Acriss $replacementAcriss
                 */
                foreach ($parameterSetting->getReplacementAcrissCollection() as $replacementAcriss) {
                    if ($replacementAcriss->getVehicleGroupName() != null && !in_array($replacementAcriss->getVehicleGroupName(), $replacementCarGroupNames)) {
                        $replacementCarGroupNames[] = $replacementAcriss->getVehicleGroupName();
                    }
                }

            }

            $parameterSettingList[] = [
                'id' => $parameterSetting->getId(),
                'parameterSettingType' => $parameterSetting->getType()->getName(),
                'parameter' => $parameterSetting->getParameter(),
                'startDate' => $parameterSetting->getStartDate() ? $parameterSetting->getStartDate()->__toString() : '',
                'endDate' =>  $parameterSetting->getEndDate() ? $parameterSetting->getEndDate()->__toString() : '',
                'carGroup' => $carGroupNames,
                'acriss' =>  $parameterSetting->getAcrissCollection() ? $parameterSetting->getAcrissCollection()->toArray() : null,
                'replacementGroup' => $replacementCarGroupNames,
                'replacementAcriss' => $parameterSetting->getReplacementAcrissCollection() ? $parameterSetting->getReplacementAcrissCollection()->toArray() : null,
                'region' => $parameterSetting->getRegionCollection() ? $parameterSetting->getRegionCollection()->toArray() : null,
                'area' => $parameterSetting->getAreaCollection() ? $parameterSetting->getAreaCollection()->toArray() : null,
                'branch' => $parameterSetting->getBranchCollection() ? $parameterSetting->getBranchCollection()->toArray() : null,
                'partner' => $parameterSetting->getPartnerCollection() ? $parameterSetting->getPartnerCollection()->toArray() : null,
                'startTime' =>  $parameterSetting->getStartTime() ? $parameterSetting->getStartTime()->getTime() : null,
                'endTime' => $parameterSetting->getEndTime() ? $parameterSetting->getEndTime()->getTime() : null,
                'connectedVehicle' => $parameterSetting->isConnectedVehicle(),
                'status' => $parameterSetting->isActive(),
                'creationUser' => $parameterSetting->getCreationUser() ? $parameterSetting->getCreationUser()->getName() : null,
                'creationDate' => $parameterSetting->getCreationDate() ? $parameterSetting->getCreationDate()->__toString() : null,
            ];
        }

        $parameterSettingResponse['total'] = $totalRows;
        $parameterSettingResponse['rows'] = $parameterSettingList;

        return new FilterParameterSettingsResponse($parameterSettingResponse);
    }


    /**
     * @param FilterParameterSettingsQuery $query
     * @return ParameterSettingCriteria
     */
    private function setCriteria(FilterParameterSettingsQuery $query): ParameterSettingCriteria
    {
        $sortCollection = null;
        $filterCollection = new FilterCollection([]);

        if (!empty($query->getAcrissIds())) $filterCollection->add(new Filter('ACRISSIDIN', new FilterOperator(FilterOperator::IN), $query->getAcrissIds()));

        if (!empty($query->getSubstitutionAcrissIds())) $filterCollection->add(new Filter('SUBSTITUTIONACRISSIDIN', new FilterOperator(FilterOperator::IN), $query->getSubstitutionAcrissIds()));

        if (!empty($query->getRegionIds())) $filterCollection->add(new Filter('REGIONIDIN', new FilterOperator(FilterOperator::IN), $query->getRegionIds()));

        if (!empty($query->getAreaIds())) $filterCollection->add(new Filter('AREAIDIN', new FilterOperator(FilterOperator::IN), $query->getAreaIds()));

        if (!empty($query->getBranchIds())) $filterCollection->add(new Filter('BRANCHIDIN', new FilterOperator(FilterOperator::IN), $query->getBranchIds()));

        if (!empty($query->getParamaterSettingTypeId())) $filterCollection->add(new Filter('TYPEID', new FilterOperator(FilterOperator::EQUAL), $query->getParamaterSettingTypeId()));

        if (!empty($query->getConnectedVehicle())) $filterCollection->add(new Filter('CONNECTEDVEHICLE', new FilterOperator(FilterOperator::EQUAL), $query->getConnectedVehicle()));

        if (!empty($query->getStartDate())) $filterCollection->add(new Filter('INITDATE', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getStartDate())));

        if (!empty($query->getEndDate())) $filterCollection->add(new Filter('ENDDATE', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getEndDate())));

        if (!empty($query->getCreationDateFrom())) {
            $format = (!empty($query->getCreationTimeFrom())) ? 'd/m/Y H:i:s' : 'd/m/Y';
            $creationDateFrom = (!empty($query->getCreationTimeFrom())) ? DateTimeValueObject::createFromString("{$query->getCreationDateFrom()} {$query->getCreationTimeFrom()}") : DateValueObject::createFromString($query->getCreationDateFrom());
            $creationDateFrom = (!empty($query->getCreationTimeFrom())) ? Utils::formatStringDateTimeToOdataDate($creationDateFrom->__toString(), $format) : Utils::formatDateToFirstMinuteDateTime($creationDateFrom->__toString(), $format);

            $filterCollection->add(new Filter('CREATIONDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), $creationDateFrom));
        }

        if (!empty($query->getCreationDateTo())) {
            $format = (!empty($query->getCreationTimeTo())) ? 'd/m/Y H:i:s' : 'd/m/Y';
            $creationDateTo = (!empty($query->getCreationTimeTo())) ? DateTimeValueObject::createFromString("{$query->getCreationDateTo()} {$query->getCreationTimeTo()}") : DateValueObject::createFromString($query->getCreationDateTo());
            $creationDateTo = (!empty($query->getCreationTimeTo())) ? Utils::formatStringDateTimeToOdataDate($creationDateTo->__toString(), $format) : Utils::formatDateToFirstMinuteDateTime($creationDateTo->__toString(), $format);

            $filterCollection->add(new Filter('CREATIONDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), $creationDateTo));
        }


        if (!empty($query->getSort()) && !empty($query->getOrder())) {
            $sortCollection = new SortCollection([
                new Sort($query->getSort(), $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);
        $criteria = new ParameterSettingCriteria($filterCollection, $pagination);

        return $criteria;
    }
}
