<?php
declare(strict_types=1);


namespace Distribution\Maintenance\Infrastructure;

use DateTime;
use Distribution\Maintenance\Domain\Maintenance;
use Distribution\Maintenance\Domain\MaintenanceRepository;

use Exception;
use Faker\Factory;
use Faker\Generator;
use Shared\Domain\ValueObject\DateValueObject;

class MaintenanceRepositoryFake implements MaintenanceRepository
{
    // TODO: BORRAR SI NO SE USA

    /**
     * @var array
     */
    public array $regionList;
    /**
     * @var array
     */
    private array $objectList;

    private Generator $faker;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->faker = Factory::create();
        $this->objectList = [];

        $totalMaintenace = 10;

        for($i=0; $i<$totalMaintenace; $i++){
            $this->objectList[]= new Maintenance((string)$i, new DateValueObject(new DateTime($this->faker->date())));
        }
    }

    public function getById(int $id): Maintenance
    {
        return $this->objectList[0];
    }
}