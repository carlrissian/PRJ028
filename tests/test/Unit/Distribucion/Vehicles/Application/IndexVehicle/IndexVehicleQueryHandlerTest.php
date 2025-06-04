<?php


namespace App\Tests\test\Unit\Distribucion\Vehicles\Application\IndexVehicle;


use Distribution\Acriss\Domain\AcrissCollection;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\CarClass\Domain\CarClassCollection;
use Distribution\CarClass\Domain\CarClassRepository;
use Distribution\Vehicle\Application\IndexVehicle\IndexVehicleQuery;
use Distribution\Vehicle\Application\IndexVehicle\IndexVehicleQueryHandler;
use Distribution\Country\Domain\CountryCollection;
use Distribution\Country\Domain\CountryRepository;
use Distribution\Delegation\Domain\BranchCollection;
use Distribution\Delegation\Domain\BranchRepository;
use Distribution\Fuel\Domain\FuelCollection;
use Distribution\Fuel\Domain\FuelRepository;
use Distribution\Group\Domain\CarGroupCollection;
use Distribution\Group\Domain\CarGroupRepository;
use Distribution\Brand\Domain\BrandCollection;
use Distribution\Brand\Domain\BrandRepository;
use Distribution\Model\Domain\ModelCollection;
use Distribution\Model\Domain\ModelRepository;
use Distribution\ShoppingType\Domain\ResaleCodeCollection;
use Distribution\ShoppingType\Domain\ResaleCodeRepository;
use Distribution\VehicleStatus\Domain\StateCollection;
use Distribution\VehicleStatus\Domain\StatusRepository;
use Distribution\VehicleSubStatus\Domain\SubStateCollection;
use Distribution\VehicleSubStatus\Domain\VehicleSubStatusRepository;
use Distribution\Transmission\Domain\TransmissionCollection;
use Distribution\Transmission\Domain\TransmissionRepository;
use Distribution\Zone\Domain\ZoneCollection;
use Distribution\Zone\Domain\ZoneRepository;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class IndexVehicleQueryHandlerTest extends TestCase
{
    private $indexVehicleQueryHandler;

    protected function setUp()
    {
        $this->indexVehicleQueryHandler = new IndexVehicleQueryHandler(
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
            $this->createMock(VehicleSubStatusRepository::class)
        );
    }

    /** @test */
    public function get_list_vehicle(): void
    {
        $vehicles = $this->indexVehicleQueryHandler->handler(new IndexVehicleQuery());
        $this->assertInstanceOf(CarGroupCollection::class, $vehicles->getGroupCollection());
        $this->assertInstanceOf(CountryCollection::class, $vehicles->getCountryCollection());
        $this->assertInstanceOf(ZoneCollection::class, $vehicles->getZoneCollection());
        $this->assertInstanceOf(BranchCollection::class, $vehicles->getDelegationCollection());
        $this->assertInstanceOf(BrandCollection::class, $vehicles->getBrandCollection());
        $this->assertInstanceOf(ModelCollection::class, $vehicles->getModelCollection());
        $this->assertInstanceOf(CarClassCollection::class, $vehicles->getCarClassCollection());
        $this->assertInstanceOf(FuelCollection::class, $vehicles->getFuelCollection());
        $this->assertInstanceOf(AcrissCollection::class, $vehicles->getAcrissCollection());
        $this->assertInstanceOf(ResaleCodeCollection::class, $vehicles->getShoppingTypeCollection());
        $this->assertInstanceOf(TransmissionCollection::class, $vehicles->getTransmissionCollection());
        $this->assertInstanceOf(StateCollection::class, $vehicles->getStateCollection());
        $this->assertInstanceOf(SubStateCollection::class, $vehicles->getSubStateCollection());
    }
}