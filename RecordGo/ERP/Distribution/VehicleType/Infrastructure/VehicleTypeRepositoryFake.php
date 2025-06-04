<?php
declare(strict_types=1);


namespace Distribution\VehicleType\Infrastructure;

use Distribution\VehicleType\Domain\VehicleType;
use Distribution\VehicleType\Domain\VehicleTypeCollection;
use Distribution\VehicleType\Domain\VehicleTypeCriteria;
use Distribution\VehicleType\Domain\VehicleTypeGetByResponse;
use Distribution\VehicleType\Domain\VehicleTypeRepository;


class VehicleTypeRepositoryFake implements VehicleTypeRepository
{

    /**
     * @var array
     */
    public array $vehicleType;

    public function __construct()
    {
        $this->vehicleType = [
            [ 'id' => 1, 'name' => 'CAR'],
            [ 'id' => 2, 'name' => 'VAN']
        ];
    }

    public function getBy(VehicleTypeCriteria $criteria): VehicleTypeGetByResponse
    {
        $objectArray = [];

        foreach($this->vehicleType as $item) {
            $objectArray[] = new VehicleType($item['id'], $item['name']);
        }
        $collection = new VehicleTypeCollection($objectArray);

        return new VehicleTypeGetByResponse($collection, $collection->count());
    }

    final public function getIndex(int $id): ?int
    {
        $ret = array_search($id, array_column($this->vehicleType,'id'));
        return ($ret===false)?null:$ret;
    }

    /**
     * @param int $id
     * @return VehicleType|null
     */
    final public function getById(int $id): ?VehicleType
    {
        $index = $this->getIndex($id);
        return ($index!==null)?new VehicleType($this->vehicleType[$index]['id'], $this->vehicleType[$index]['name']):null;
    }
}