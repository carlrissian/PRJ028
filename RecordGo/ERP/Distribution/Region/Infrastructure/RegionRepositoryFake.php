<?php
declare(strict_types=1);


namespace Distribution\Region\Infrastructure;

use Distribution\Country\Domain\Country;
use Distribution\Region\Domain\Region;
use Distribution\Region\Domain\RegionCollection;
use Distribution\Region\Domain\RegionCriteria;
use Distribution\Region\Domain\RegionGetByResponse;
use Distribution\Region\Domain\RegionRepository;
use Shared\Domain\Criteria\FilterOperator;

class RegionRepositoryFake implements RegionRepository
{
    /**
     * @var array
     */
    public array $regionList;
    /**
     * @var array
     */
    private array $objectList;

    public function __construct()
    {
        $this->objectList = [];

        $this->regionList = [
            [ 'id' => 1, 'name' => 'Norte', 'country' => ['id' => 1, 'name' => 'España']],
            [ 'id' => 2, 'name' => 'Sud', 'country' => ['id' => 1, 'name' => 'España']],
            ['id' => 3, 'name' => 'Este', 'country' => ['id' => 1, 'name' => 'España']],
            ['id' => 4, 'name' => 'Oeste', 'country' => ['id' => 1, 'name' => 'España']],
            ['id' => 5, 'name' => 'Centro', 'country' => ['id' => 1, 'name' => 'España']],
            ['id' => 6, 'name' => 'Barrio bajo', 'country' => ['id' => 2, 'name' => 'Grecia']],
            [ 'id' => 7, 'name' => 'Barrio medio', 'country' => ['id' => 2, 'name' => 'Grecia']],
            ['id' => 8, 'name' => 'Barrio Alto', 'country' => ['id' => 2, 'name' => 'Grecia']],
            ['id' => 9, 'name' => 'A', 'country' => ['id' => 3, 'name' => 'Portugal']],
            ['id' => 10, 'name' => 'B', 'country' => ['id' => 3, 'name' => 'Portugal']],
            ['id' => 11, 'name' => 'C', 'country' => ['id' => 3, 'name' => 'Portugal']],
            ['id' => 12, 'name' => 'D', 'country' => ['id' => 3, 'name' => 'Portugal']],
            ['id' => 13, 'name' => 'E', 'country' => ['id' => 3, 'name' => 'Portugal']],
        ];

        foreach($this->regionList as $region){
            $this->objectList[]= new Region($region['id'], $region['name'], new Country($region['country']['id'], $region['country']['name']));
        }
    }

    final public function getBy(RegionCriteria $regionCriteria): RegionGetByResponse
    {
        $responseArray = [];

        if($regionCriteria->hasFilters()){
            /**
             * Filtro de busqueda de Region según Id País
             */
            foreach ($regionCriteria->getFilters(['countryId'], [FilterOperator::IN]) as $filter) {
                $responseArray = array_filter(
                    $this->objectList,
                    function ($object) use ($filter) {
                        /**
                         * @var $object Region
                         */
                        return in_array($object->getCountry()->getId(), $filter->getValue());
                    }
                );
            }
            foreach ($regionCriteria->getFilters(['countryId'], [FilterOperator::EQUAL]) as $filter) {
                $responseArray = array_filter(
                    $this->objectList,
                    function ($object) use ($filter) {
                        /**
                         * @var $object Region
                         */
                        return $object->getCountry()->getId()== $filter->getValue();
                    }
                );
            }
            /**
             * Filtro de busqueda de Region según Id Región
             */
            foreach ($regionCriteria->getFilters(['regionId'], [FilterOperator::EQUAL]) as $filter) {

                $responseArray = array_filter(
                    $this->objectList,
                    function ($object) use ($filter) {
                        /**
                         * @var $object Region
                         */
                        return $object->getId() == $filter->getValue();
                    }
                );
            }
        }else{
            foreach ($this->objectList as $region){
                $responseArray[] = $region;
            }
        }

        $collection = new RegionCollection($responseArray);

        return new RegionGetByResponse($collection, $collection->count());
    }

    /**
     * @param int $id
     * @return Region|null
     */
    final public function getById(int $id): ?Region
    {
        $responseArray = array_filter(
            $this->objectList,
            function ($object) use ($id) {
                /**
                 * @var $object Region
                 */
                return $object->getId() == $id;
            }
        );
        return $responseArray[0] ?? null;
    }
    final public function arrayToRegion(array $regionArray): Region
    {
        return new Region(intval($regionArray['ID']), $regionArray['NAME']);
    }

    final public function arrayListToArrayRegion(array $regionList): array
    {
        $regions = [];
        if (count($regionList)>0){
            for ($i = 0; $i < count($regionList); $i++){
                $regions[] = $this->arrayToRegion($regionList[$i]);
            }
        }
        return $regions;
    }

}