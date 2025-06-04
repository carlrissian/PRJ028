<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Application\StoreParameterSetting;

use Exception;
use Distribution\ParameterSetting\Domain\Area;
use Shared\Domain\ValueObject\DateValueObject;
use Shared\Domain\ValueObject\TimeValueObject;
use Distribution\ParameterSetting\Domain\Acriss;
use Distribution\ParameterSetting\Domain\Branch;
use Distribution\ParameterSetting\Domain\Region;
use Distribution\ParameterSetting\Domain\Partner;
use Distribution\ParameterSetting\Domain\AreaCollection;
use Distribution\ParameterSetting\Domain\AcrissCollection;
use Distribution\ParameterSetting\Domain\BranchCollection;
use Distribution\ParameterSetting\Domain\ParameterSetting;
use Distribution\ParameterSetting\Domain\ParameterSettingCriteria;
use Distribution\ParameterSetting\Domain\RegionCollection;
use Distribution\ParameterSetting\Domain\PartnerCollection;
use Distribution\ParameterSettingType\Domain\ParameterSettingType;
use Distribution\ParameterSetting\Domain\ParameterSettingRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Utils\Utils;
class StoreParameterSettingCommandHandler
{
    /**
     * @var ParameterSettingRepository
     */
    private ParameterSettingRepository $parameterSettingRepository;

    /**
     * StoreParameterSettingCommandHandler constructor.
     * @param ParameterSettingRepository $parameterSettingRepository

     */
    public function __construct(ParameterSettingRepository $parameterSettingRepository)
    {
        $this->parameterSettingRepository = $parameterSettingRepository;
    }

    /**
     * @param StoreParameterSettingCommand $command
     * @return StoreParameterSettingResponse
     */
    final public function handle(StoreParameterSettingCommand $command): StoreParameterSettingResponse
    {
        [$regionCollection, $areaCollection, $branchCollection, $partnerCollection, $acrissCollection, $replacementAcrissCollection] = null;

        if ($command->getAcrissIds()) {
            $acrissCollection = new AcrissCollection([]);
            foreach ($command->getAcrissIds() as $acrissId) {
                $acrissCollection->add(new Acriss(intval($acrissId)));
            }
        }

        if ($command->getReplacementAcrissIds()) {
            $replacementAcrissCollection = new AcrissCollection([]);
            foreach ($command->getReplacementAcrissIds() as $acrissId) {
                $replacementAcrissCollection->add(new Acriss(intval($acrissId)));
            }
        }


        // Solo se tiene que enviar 1 de los tipos de localizaciones con prioridad: DELEGACIÓN > AREA > REGION
        if ($command->getBranchIds()) {
            $branchCollection = new BranchCollection([]);
            foreach ($command->getBranchIds() as $branchId) {
                $branchCollection->add(new Branch(intval($branchId)));
            }
        }else  if ($command->getAreaIds()) {
            $areaCollection = new AreaCollection([]);

            foreach ($command->getAreaIds() as $areaId) {
                $areaCollection->add(new Area(intval($areaId)));
            }
        } else if ($command->getRegionIds()) {
            $regionCollection = new RegionCollection([]);
            foreach ($command->getRegionIds() as $regionId) {
                $regionCollection->add(new Region(intval($regionId), ''));
            }
        }


        if ($command->getPartnerIds()) {
            $partnerCollection = new PartnerCollection([]);
            foreach ($command->getPartnerIds() as $partnerId) {
                $partnerCollection->add(new Partner(intval($partnerId), ''));
            }
        }
         if($command->getStartDate() && $command->getEndDate() && $command->getAcrissIds()) {
            $response = $this->parameterSettingRepository->getBy(
                new ParameterSettingCriteria(
                    new FilterCollection([
                        new Filter('ACRISSIDIN', new FilterOperator(FilterOperator::IN), $command->getAcrissIds()),
                        new Filter('INITDATE', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($command->getStartDate())),
                        new Filter('ENDDATE', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($command->getEndDate())),
                        new Filter('ACTIVE', new FilterOperator(FilterOperator::EQUAL), 1)  
                    ])
                )
            );
        
            $totalRows = $response->getTotalRows();
            $parameterSettingCollection = $response->getCollection();
            
            if ($totalRows > 0) {
                // Obtener los nombres de los ACRISS existentes
                $existingAcrissNames = [];
                foreach ($parameterSettingCollection as $existingSetting) {
                    foreach ($existingSetting->getAcrissCollection() as $acriss) {
                        $existingAcrissNames[] = $acriss->getName();
                    }
                }
                
                // Eliminar duplicados y crear la cadena de nombres
                $uniqueAcrissNames = array_unique($existingAcrissNames);
                $acrissNamesString = implode(', ', $uniqueAcrissNames);
                
                $startDate = $command->getStartDate();
                $endDate = $command->getEndDate();
                
                if ($command->getIsOverride() == false) {
                    throw new Exception("Ya existe un(s) parámetro(s) para el ACRISS $acrissNamesString entre el periodo $startDate - $endDate");
                } else {
                    // Si es override, borramos los parámetros existentes
                    foreach ($parameterSettingCollection as $existingSetting) {
                        $this->parameterSettingRepository->delete($existingSetting->getId());
                    }
                }
            }
        }

        $parameterSetting = new ParameterSetting(
            null,
            $command->getStartDate() ? DateValueObject::createFromString($command->getStartDate()) : null,
            $command->getEndDate() ? DateValueObject::createFromString($command->getEndDate()) : null,
            new ParameterSettingType($command->getType()),
            $command->getParameter(),
            null,
            $acrissCollection,
            $replacementAcrissCollection,
            $regionCollection,
            $areaCollection,
            $branchCollection,
            $partnerCollection,
            $command->getStartTime() ? TimeValueObject::createFromString($command->getStartTime()) : TimeValueObject::createFromString('00:00'),
            $command->getEndTime() ? TimeValueObject::createFromString($command->getEndTime()) : TimeValueObject::createFromString('23:59'),
            $command->getConnectedVehicle(),
            true
        );

        $response = $this->parameterSettingRepository->store($parameterSetting);

        return new StoreParameterSettingResponse($response);
    }
}
