<?php
declare(strict_types=1);

namespace Distribution\Brand\Infrastructure;

use Distribution\Brand\Domain\Brand;
use Distribution\Brand\Domain\BrandCollection;
use Distribution\Brand\Domain\BrandCriteria;
use Distribution\Brand\Domain\BrandGetByResponse;
use Distribution\Brand\Domain\BrandRepository;

/**
 * Class BrandRepositoryFake
 * @package Distribution\Brand\Infrastructure
 */
class BrandRepositoryFake implements BrandRepository
{
    /**
     * @var array
     */
    public array $brandList;

    /**
     * BrandRepositoryFake constructor.
     */
    public function __construct()
    {
        $this->brandList = [
            ['id' => 1, 'name' => 'Alpine'],
            ['id' => 2, 'name' => 'Abarth'],
            ['id' => 3, 'name' => 'Bugatti'],
            ['id' => 4, 'name' => 'BMW'],
            ['id' => 5, 'name' => 'Dacia'],
            ['id' => 6, 'name' => 'Ford'],
            ['id' => 7, 'name' => 'Ford'],
            ['id' => 8, 'name' => 'Hyundai'],
            ['id' => 9, 'name' => 'Mazda'],
            ['id' => 10, 'name' => 'Peugeot']
        ];
    }

    /**
     * @param BrandCriteria $brandCriteria
     * @return BrandGetByResponse
     */
    public function getBy(BrandCriteria $brandCriteria): BrandGetByResponse
    {
        $brands = [];

        foreach ($this->brandList as $brand){
            $brands[] = new Brand($brand['id'], $brand['name']);
        }

        return new BrandGetByResponse(new BrandCollection($brands), count($brands));
    }

    final public function getById(int $id): ?Brand
    {
        $brand = null;
        $index = $this->getIndex($id);
        if ($index !== null){
            $provinceItem = $this->brandList[$index];
            $brand = new Brand($provinceItem['id'], $provinceItem['name']);
        }
        return $brand;
    }

    final public function getIndex(int $id): ?int
    {
        $ret = array_search($id, array_column($this->brandList,'id'));
        return ($ret === false)?null:$ret;
    }

}
