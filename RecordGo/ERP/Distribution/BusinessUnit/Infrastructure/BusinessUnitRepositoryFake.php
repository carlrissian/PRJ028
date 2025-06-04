<?php
declare(strict_types=1);


namespace Distribution\BusinessUnit\Infrastructure;

use Distribution\BusinessUnit\Domain\BusinessUnit;
use Distribution\BusinessUnit\Domain\BusinessUnitCollection;
use Distribution\BusinessUnit\Domain\BusinessUnitCriteria;
use Distribution\BusinessUnit\Domain\BusinessUnitGetByResponse;
use Distribution\BusinessUnit\Domain\BusinessUnitRepository;


class BusinessUnitRepositoryFake implements BusinessUnitRepository
{
    /**
     * @var array
     */
    public array $businessUnitList;

    public function __construct()
    {

        $this->businessUnitList = [
            ['id' => 1, 'name' => 'RENT A CAR'],
            ['id' => 2, 'name' => 'VO-B2C'],
            ['id' => 3, 'name' => 'VO-B2B'],
            ['id' => 4, 'name' => 'CAR-SHARING'],
            ['id' => 5, 'name' => 'RENTING']
        ];
    }

    public function getBy(BusinessUnitCriteria $criteria): BusinessUnitGetByResponse
    {

        $businessUnitCollection = new BusinessUnitCollection([]);

        foreach ($this->businessUnitList as $businessUnit){
            $businessUnitCollection->add(new BusinessUnit($businessUnit['id'], $businessUnit['name']));
        }

        return new BusinessUnitGetByResponse($businessUnitCollection, $businessUnitCollection->count());
    }

    public function getIndex(int $id): int
    {
        return array_search($id, array_column($this->businessUnitList,'id'));
    }
}