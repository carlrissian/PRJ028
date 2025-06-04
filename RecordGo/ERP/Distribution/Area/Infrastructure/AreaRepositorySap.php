<?php

declare(strict_types=1);

namespace Distribution\Area\Infrastructure;

use Closure;
use Exception;
use Distribution\Area\Domain\Area;
use Distribution\Region\Domain\Region;
use Shared\Repository\RepositoryHelper;
use Distribution\Area\Domain\AreaCriteria;
use Distribution\Area\Domain\AreaCollection;
use Distribution\Area\Domain\AreaRepository;
use Distribution\Area\Domain\AreaGetByResponse;

class AreaRepositorySap extends RepositoryHelper implements AreaRepository
{
    private const PREFIX_FUNCTION_NAME = 'AreaList/AreaListRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(AreaCriteria $criteria): AreaGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new AreaCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));
            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TAreaListResponse', $collection, Closure::fromCallable([$this, 'arrayToArea']));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return (new AreaGetByResponse($collection, $totalRows ?? 0));
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getById(int $id): ?Area
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $response = $this->genericGetById('GET', $functionName, 'TAreaListResponse');
            $area = $this->arrayToArea($response);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return $area;
    }


    final private function arrayToArea(array $areaArray): Area
    {
        return new Area(
            intval($areaArray['ID']),
            $areaArray['AREANAME'] ?? $areaArray['NAME'] ?? null,
            (isset($areaArray['Region'])) ?
                new Region(
                    intval($areaArray['Region']['ID']),
                    $areaArray['Region']['REGIONNAME']
                ) : null
        );
    }
    final private function arrayListToArrayArea(array $areaList): array
    {
        $areas = [];
        if (count($areaList) > 0) {
            for ($i = 0; $i < count($areaList); $i++) {
                $areas[] = $this->arrayToArea($areaList[$i]);
            }
        }
        return $areas;
    }
}
