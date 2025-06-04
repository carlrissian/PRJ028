<?php
declare(strict_types=1);


namespace Distribution\ParameterSettingType\Infrastructure;


use Distribution\ParameterSettingType\Domain\ParameterSettingType;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeCollection;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeGetByResponse;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeRepository;
use Doctrine\Common\Collections\Criteria;

class ParameterSettingTypeFake implements ParameterSettingTypeRepository
{
    //TODO: SUSTITUIR POR PARAMETERSETTINGTYPEREPOSITORYSAP

    public function getBy(Criteria $criteria): ParameterSettingTypeGetByResponse
    {
        $parameter[] = new ParameterSettingType( 1, 'Grupo');
        $parameter[] = new ParameterSettingType( 2, 'Orden Upgrades');
        $parameter[] = new ParameterSettingType( 3, 'Familia Venta');

        $collection = new ParameterSettingTypeCollection($parameter);
        return new ParameterSettingTypeGetByResponse($collection, $collection->count());
    }
}