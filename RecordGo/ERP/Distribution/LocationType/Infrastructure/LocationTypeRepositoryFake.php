<?php
declare(strict_types=1);


namespace Distribution\LocationType\Infrastructure;


use Distribution\LocationType\Domain\LocationType;
use Distribution\LocationType\Domain\LocationTypeCollection;
use Distribution\LocationType\Domain\LocationTypeCriteria;
use Distribution\LocationType\Domain\LocationTypeGetByResponse;
use Distribution\LocationType\Domain\LocationTypeRepository;

class LocationTypeRepositoryFake implements LocationTypeRepository
{
    /**
     * @var array
     */
    public array $locationTypeList;

    public function __construct(){
        $this->locationTypeList = [
            ['id' => 1, 'name' => 'FrontDesk IA Tierra'],
            ['id' => 2, 'name' => 'FronDesk IA Air'],
            ['id' => 3, 'name' => 'OfficeOA'],
            ['id' => 4, 'name' => 'OperationsCentral'],
            ['id' => 5, 'name' => 'AirportParking'],
            ['id' => 6, 'name' => 'Campa']
        ];
    }

    public function getBy(LocationTypeCriteria $locationTypeCriteria): LocationTypeGetByResponse
    {
        $locationTypeCollection = new LocationTypeCollection([]);

        foreach($this->locationTypeList as $locationType) {
            $locationTypeCollection->add( new LocationType($locationType['id'], $locationType['name']) );
        }

        return new LocationTypeGetByResponse($locationTypeCollection, $locationTypeCollection->count());
    }

}