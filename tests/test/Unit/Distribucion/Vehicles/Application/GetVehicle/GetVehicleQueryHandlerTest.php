<?php

namespace App\Tests\test\Unit\Distribucion\Vehicles\Application\GetVehicle;


use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\BranchOffice\Domain\BranchOfficeRepository;
use Distribution\CarClass\Domain\CarClassRepository;
use Distribution\Vehicle\Application\FilterVehicle\GetVehicleQuery;
use Distribution\Vehicle\Application\FilterVehicle\GetVehicleQueryHandler;
use Distribution\Vehicle\Domain\VehicleRepository;
use Distribution\Country\Domain\CountryRepository;
use Distribution\Delegation\Domain\BranchRepository;
use Distribution\Fuel\Domain\FuelRepository;
use Distribution\Group\Domain\CarGroupRepository;
use Distribution\Brand\Domain\BrandRepository;
use Distribution\Model\Domain\ModelRepository;
use Distribution\ShoppingType\Domain\ResaleCodeRepository;
use Distribution\VehicleStatus\Domain\StatusRepository;
use Distribution\SubModel\Domain\SubModelRepository;
use Distribution\VehicleSubStatus\Domain\VehicleSubStatusRepository;
use Distribution\Transmission\Domain\TransmissionRepository;
use Distribution\Zone\Domain\ZoneRepository;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class GetVehicleQueryHandlerTest extends TestCase
{

    private $getVehicleQueryHandler;

    protected function setUp()
    {
        $this->getVehicleQueryHandler = new GetVehicleQueryHandler(
            $this->createMock(VehicleRepository::class),
            $this->createMock(CarGroupRepository::class),
            $this->createMock(CountryRepository::class),
            $this->createMock(ZoneRepository::class),
            $this->createMock(BranchRepository::class),
            $this->createMock(BrandRepository::class),
            $this->createMock(ModelRepository::class),
            $this->createMock(CarClassRepository::class),
            $this->createMock(FuelRepository::class),
            $this->createMock(AcrissRepository::class),
            $this->createMock(ResaleCodeRepository::class),
            $this->createMock(TransmissionRepository::class),
            $this->createMock(StatusRepository::class),
            $this->createMock(VehicleSubStatusRepository::class),
            $this->createMock(BranchOfficeRepository::class),
            $this->createMock(SubModelRepository::class)
        );
    }

    /** @test */
    public function get_list_vehicle(): void
    {
        $vehicles = $this->getVehicleQueryHandler->handle(new GetVehicleQuery());
        $this->assertIsArray($vehicles->vehicles());
    }
}
