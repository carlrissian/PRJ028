<?php
declare(strict_types=1);

namespace Distribution\VehicleStatus\Infrastructure;

use Distribution\VehicleStatus\Domain\VehicleStatus;
use Distribution\VehicleStatus\Domain\VehicleStatusCollection;
use Distribution\VehicleStatus\Domain\VehicleStatusCriteria;
use Distribution\VehicleStatus\Domain\VehicleStatusGetByResponse;
use Distribution\VehicleStatus\Domain\VehicleStatusRepository;


class VehicleStatusRepositoryFake implements VehicleStatusRepository
{
    /**
     * @var array
     */
    public array $vehicleStatusList;

    public function __construct()
    {

        $this->vehicleStatusList = [
            //Estados con botón ver detalle en historico vehiculo.
            ['id' => 1, 'name' => 'On rent'],
            ['id' => 2, 'name' => 'Crane'],
            ['id' => 3, 'name' => 'On Transport'],
            ['id' => 4, 'name' => 'On Repair'],
            ['id' => 5, 'name' => 'On transport (sale)'],
            ['id' => 6, 'name' => 'Sale'],
            ['id' => 7, 'name' => 'Workshop (sale)'],
            ['id' => 8, 'name' => 'Pending repair'],
            ['id' => 9, 'name' => 'Pending WS (Sale)'],
            ['id' => 10, 'name' => 'Sold (On transport)'],
            ['id' => 11, 'name' => 'Sold repair'],
            ['id' => 12, 'name' => 'Sold'],
            ['id' => 13, 'name' => 'On transport (workshop)'],

            //Estados sin botón ver detalle en historico vehiculo.
            ['id' => 14, 'name' => 'New Vin'],
            ['id' => 15, 'name' => 'First rental preparation'],
            ['id' => 16, 'name' => 'Available'],
            ['id' => 17, 'name' => 'Stock'],
            ['id' => 18, 'name' => 'Stolen'],
            ['id' => 19, 'name' => 'Stolen (pending)'],
            ['id' => 20, 'name' => 'Wreck  (pending)'],
            ['id' => 21, 'name' => 'Wreck'],
        ];
    }

    final public function getBy(VehicleStatusCriteria $vehicleStatusCriteria): VehicleStatusGetByResponse
    {
        $vehicleStatusCollection = new VehicleStatusCollection([]);
        foreach ($this->vehicleStatusList as $vehicleStatus){
            $vehicleStatusCollection->add(new VehicleStatus($vehicleStatus['id'], $vehicleStatus['name']));
        }

        return new VehicleStatusGetByResponse($vehicleStatusCollection, $vehicleStatusCollection->count());
    }

    /**
     * @param int $id
     * @return VehicleStatus|null
     */
    final public function getById(int $id): ?VehicleStatus
    {
        $responseArray = array_filter(
            $this->vehicleStatusList,
            function ($item) use ($id) {
                return $item['id'] == $id;
            }
        );
        $responseArray = array_values($responseArray);
        return ($responseArray)?new VehicleStatus($responseArray[0]['id'], $responseArray[0]['name']):null;
    }
}
