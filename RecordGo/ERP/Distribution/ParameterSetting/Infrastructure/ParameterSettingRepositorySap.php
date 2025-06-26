<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Infrastructure;

use Exception;
use Shared\Domain\User;
use Shared\Utils\Utils;
use Shared\Domain\OperationResponse;
use Shared\Repository\RepositoryHelper;
use Distribution\ParameterSetting\Domain\Area;
use Shared\Domain\ValueObject\DateValueObject;
use Shared\Domain\ValueObject\TimeValueObject;
use Distribution\ParameterSetting\Domain\Acriss;
use Distribution\ParameterSetting\Domain\Branch;
use Distribution\ParameterSetting\Domain\Region;
use Distribution\ParameterSetting\Domain\Partner;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\ParameterSetting\Domain\AreaCollection;
use Distribution\ParameterSetting\Domain\AcrissCollection;
use Distribution\ParameterSetting\Domain\BranchCollection;
use Distribution\ParameterSetting\Domain\ParameterSetting;
use Distribution\ParameterSetting\Domain\RegionCollection;
use Distribution\ParameterSetting\Domain\PartnerCollection;
use Distribution\ParameterSetting\Domain\ParameterSettingCriteria;
use Distribution\ParameterSettingType\Domain\ParameterSettingType;
use Distribution\ParameterSetting\Domain\ParameterSettingCollection;
use Distribution\ParameterSetting\Domain\ParameterSettingRepository;
use Distribution\ParameterSetting\Domain\ParameterSettingGetByResponse;
use Distribution\ParameterSetting\Domain\ParameterSettingCalendarCriteria;
use Distribution\ParameterSetting\Domain\ParameterSettingOperationResponse;

class ParameterSettingRepositorySap extends RepositoryHelper implements ParameterSettingRepository
{
    private const PREFIX_FUNCTION_NAME = 'ParameterSetting/ParameterSettingRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(ParameterSettingCriteria $criteria): ParameterSettingGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new ParameterSettingCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new Exception("The getBy request hasn't returned a response");
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TParameterSettingResponse');

            foreach ($responseArray['TParameterSettingResponse'] as $itemArray) {
                $collection->add($this->arrayToParameterSetting($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }


        return new ParameterSettingGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     */
    final public function getParameterSettingCalendarBy(ParameterSettingCalendarCriteria $parameterSettingCriteria): ParameterSettingGetByResponse
    {
        // TODO: Implement getParameterSettingCalendarBy() method.
        return new ParameterSettingGetByResponse(new ParameterSettingCollection([]), 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function store(ParameterSetting $parameterSetting): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $parameterSetting->getId();

        try {
            $body = json_encode($parameterSetting->toArray());

            $response = $this->sapRequestHelper->request('POST', $functionName, $body);
            $responseArray = json_decode($response, true);

            return intval($responseArray['ID']);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): ParameterSettingOperationResponse
    {
        $functionName = sprintf('%s_%s/%d', self::PREFIX_FUNCTION_NAME, __FUNCTION__, $id);

        try {
            $response = $this->sapRequestHelper->request('DELETE', $functionName, "");
            $responseArray = json_decode($response, true);

            return new ParameterSettingOperationResponse(
                isset($responseArray['ID']) ? intval($responseArray['ID']) : null,
                OperationResponse::createFromArray($responseArray['ToperationResponse'])
            );
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @param array $parameterSettingArray
     * @return ParameterSetting
     */
    final public function arrayToParameterSetting(array $parameterSettingArray): ParameterSetting
    {
        $acrissCollection = new AcrissCollection([]);
        foreach ($parameterSettingArray['ACRISSARRAY'] as $acrissArray) {
            $acrissCollection->add(new Acriss((int) $acrissArray['ID'], $acrissArray['ACRISSCODE'], $acrissArray['VEHICLEGROUPNAME']));
        }

        $replacementAcrissCollection = new AcrissCollection([]);
        foreach ($parameterSettingArray['REPLACEMENTACRISSARRAY'] as $acrissArray) {
            $replacementAcrissCollection->add(new Acriss((int) $acrissArray['ID'], $acrissArray['ACRISSCODE'], $acrissArray['VEHICLEGROUPNAME']));
        }

        $regionCollection = new RegionCollection([]);
        foreach ($parameterSettingArray['REGIONARRAY'] as $region) {
            $regionCollection->add(new Region((int) $region['ID'], $region['NAME']));
        }

        $areaCollection = new AreaCollection([]);
        foreach ($parameterSettingArray['AREAARRAY'] as $area) {
            $areaCollection->add(new Area((int) $area['ID'], $area['AREANAME']));
        }

        $brancheCollection = new BranchCollection([]);
        foreach ($parameterSettingArray['BRANCHARRAY'] as $branch) {
            $brancheCollection->add(new Branch((int) $branch['ID'], $branch['BRANCHINTNAME']));
        }

        $partnerCollection = new PartnerCollection([]);
        foreach ($parameterSettingArray['PARTNERARRAY'] as $partner) {
            $partnerCollection->add(new Partner((int) $partner['ID'], $partner['NAMESOCIAL']));
        }


        return new ParameterSetting(
            intval($parameterSettingArray['ID']),
            isset($parameterSettingArray['INITDATE']) ? new DateValueObject(Utils::convertOdataDateToDateTime($parameterSettingArray['INITDATE'])) : null,
            isset($parameterSettingArray['ENDDATE']) ? new DateValueObject(Utils::convertOdataDateToDateTime($parameterSettingArray['ENDDATE'])) : null,
            isset($parameterSettingArray['TYPE']) ?
                new ParameterSettingType(
                    intval($parameterSettingArray['TYPE']['ID']),
                    $parameterSettingArray['TYPE']['NAME']
                ) : null,
            intval($parameterSettingArray['PARAMETERLIMIT']),
            null,
            $acrissCollection,
            $replacementAcrissCollection,
            $regionCollection,
            $areaCollection,
            $brancheCollection,
            $partnerCollection,
            isset($parameterSettingArray['INITTIME']) ? new TimeValueObject(Utils::convertOdataTimeToMinutes($parameterSettingArray['INITTIME'])) : null,
            isset($parameterSettingArray['ENDTIME']) ? new TimeValueObject(Utils::convertOdataTimeToMinutes($parameterSettingArray['ENDTIME'])) : null,
            isset($parameterSettingArray['CONNECTED']) ? boolval($parameterSettingArray['CONNECTED']) : null,
            isset($parameterSettingArray['ACTIVE']) ? boolval($parameterSettingArray['ACTIVE']) : null,
            isset($parameterSettingArray['CREATIONUSER']) ?
                new User(
                    intval($parameterSettingArray['CREATIONUSER']['ID']),
                    $parameterSettingArray['CREATIONUSER']['USERALIAS']
                ) : null,
            isset($parameterSettingArray['CREATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($parameterSettingArray['CREATIONDATE'])) : null,
        );
    }
}
