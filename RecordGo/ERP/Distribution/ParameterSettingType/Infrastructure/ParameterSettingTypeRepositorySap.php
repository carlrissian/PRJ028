<?php

declare(strict_types=1);

namespace Distribution\ParameterSettingType\Infrastructure;

use Shared\Repository\RepositoryHelper;
use Doctrine\Common\Collections\Criteria;
use Distribution\ParameterSettingType\Domain\ParameterSettingType;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeCollection;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeRepository;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeGetByResponse;

class ParameterSettingTypeRepositorySap extends RepositoryHelper implements ParameterSettingTypeRepository
{
    private const PREFIX_FUNCTION_NAME = 'ParameterSettingType/ParameterSettingTypeRepository';

    /**
     * @inheritDoc
     */
    public function getBy(Criteria $criteria): ParameterSettingTypeGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        $method = 'GET';
        $collection = new ParameterSettingTypeCollection([]);

        $body = json_encode([]);

        $response = $this->sapRequestHelper->request($method, $functionName, $body);

        $response = json_decode($response, true);

        foreach ($response['TParameterSettingTypeResponse'] as $parameterTypeArray) {
            $collection->add(new ParameterSettingType(
                intval($parameterTypeArray['ID']),
                $parameterTypeArray['NAME']
            ));
        }

        return new ParameterSettingTypeGetByResponse($collection, $collection->count());
    }
}
