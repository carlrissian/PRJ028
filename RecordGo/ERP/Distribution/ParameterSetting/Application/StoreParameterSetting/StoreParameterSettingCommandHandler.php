<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Application\StoreParameterSetting;

use Exception;
use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
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
use Distribution\ParameterSetting\Domain\RegionCollection;
use Distribution\ParameterSetting\Domain\PartnerCollection;
use Distribution\ParameterSetting\Domain\ParameterSettingCriteria;
use Distribution\ParameterSettingType\Domain\ParameterSettingType;
use Distribution\ParameterSetting\Domain\ParameterSettingRepository;

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
        } else if ($command->getAreaIds()) {
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

        /* Comprobar parámetros activos que tengan asociados algún ACRISS de los seleccionados en el periodo de fechas seleccionadas */
        if ($command->getStartDate() && $command->getEndDate() && $command->getAcrissIds()) {
            $response = $this->parameterSettingRepository->getBy(
                new ParameterSettingCriteria(
                    new FilterCollection([
                        new Filter('BRANCHIDIN', new FilterOperator(FilterOperator::IN), $command->getBranchIds()),
                        new Filter('ACRISSIDIN', new FilterOperator(FilterOperator::IN), $command->getAcrissIds()),
                        new Filter('STARTDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($command->getStartDate())),
                        new Filter('ENDDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatDateToLastMinuteDateTime($command->getEndDate())),
                        new Filter('ACTIVE', new FilterOperator(FilterOperator::EQUAL), 1)
                    ])
                )
            );

            $totalRows = $response->getTotalRows();
            $parameterSettingCollection = $response->getCollection();

            if ($totalRows > 0) {
                // Obtener los nombres de los ACRISS existentes
                $existingAcriss = array_map(function ($parameterSetting) {
                    return $parameterSetting->getAcrissCollection()->toArray();
                }, $parameterSettingCollection->toArray());
                $existingAcriss = array_merge(...$existingAcriss);
                $existingAcrissNames = array_map(function ($acriss) {
                    return $acriss->getName();
                }, array_filter($existingAcriss, function ($acriss) use ($command) {
                    return in_array($acriss->getId(), $command->getAcrissIds());
                }));
                // Eliminar duplicados
                $existingAcrissNames = array_unique($existingAcrissNames);

                // Obtener los nombres de las delegaciones existentes
                $existingBranch = array_map(function ($parameterSetting) {
                    return $parameterSetting->getBranchCollection()->toArray();
                }, $parameterSettingCollection->toArray());
                $existingBranch = array_merge(...$existingBranch);
                $existingBranchNames = array_map(function ($branch) {
                    return $branch->getName();
                }, array_filter($existingBranch, function ($branch) use ($command) {
                    return in_array($branch->getId(), $command->getBranchIds());
                }));
                // Eliminar duplicados
                $existingBranchNames = array_unique($existingBranchNames);

                if ($command->getIsOverride() === false) {
                    $message = $totalRows > 1 ? "Ya existen parámetros para el/los ACRISS '%s' y delegación/es '%s' para el periodo %s - %s" : "Ya existe un parámetro para el/los ACRISS '%s' y delegación/es '%s' para el periodo %s - %s";
                    throw new Exception(sprintf($message, implode(', ', $existingAcrissNames), implode(', ', $existingBranchNames), $command->getStartDate(), $command->getEndDate()));
                }

                // Si es override, borramos los parámetros existentes
                foreach ($parameterSettingCollection as $existingSetting) {
                    $deleteResponse = $this->parameterSettingRepository->delete($existingSetting->getId());
                    if (!$deleteResponse->getOperationResponse()->wasSuccess()) {
                        throw new Exception(sprintf("Error al eliminar el parámetro existente con ID %d: %s", $existingSetting->getId(), $deleteResponse->getOperationResponse()->getMessage()));
                    }
                }
            }
        }
        /* */

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
