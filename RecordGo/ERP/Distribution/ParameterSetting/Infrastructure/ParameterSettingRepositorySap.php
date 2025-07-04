<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Infrastructure;

use Exception;
use Shared\Domain\OperationResponse;
use Shared\Repository\RepositoryHelper;
use Distribution\ParameterSetting\Domain\ParameterSetting;
use Distribution\ParameterSetting\Domain\ParameterSettingCriteria;
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
        return ParameterSetting::createFromArray($parameterSettingArray);
    }
}
