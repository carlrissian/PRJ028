<?php

namespace Distribution\ParameterSettingType\Infrastructure;

use Shared\Utils\Utils;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Distribution\ParameterSettingType\Domain\ParameterSettingType;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeCriteria;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeCollection;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeGetByResponse;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeRepositoryInterface;

class ParameterSettingTypeRepositorySap implements ParameterSettingTypeRepositoryInterface
{
    private const PREFIX_FUNCTION_NAME = 'ParameterSettingType/ParameterSettingTypeRepository';

    /**
     * @var SapRequestHelper $sapRequestHelper
     */
    public SapRequestHelper $sapRequestHelper;

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        $this->sapRequestHelper = $sapRequestHelper;
    }

    /**
     * @inheritDoc
     */
    public function getBy(ParameterSettingTypeCriteria $criteria): ParameterSettingTypeGetByResponse
    {
        $functionName = sprintf('%s_%s', self::PREFIX_FUNCTION_NAME, __FUNCTION__);
        $collection = new ParameterSettingTypeCollection([]);

        try {
            $body = json_encode(Utils::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);
            if (empty($response)) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);

            foreach ($responseArray['TParameterSettingTypeResponse'] as $itemArray) {
                $collection->add($this->arrayToParameterSettingType($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();

            return new ParameterSettingTypeGetByResponse($collection, $totalRows ?? 0);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @param array $parameterSettingTypeArray
     * @return ParameterSettingType
     */
    private function arrayToParameterSettingType(array $parameterSettingTypeArray): ParameterSettingType
    {
        return ParameterSettingType::createFromArray($parameterSettingTypeArray);
    }
}
