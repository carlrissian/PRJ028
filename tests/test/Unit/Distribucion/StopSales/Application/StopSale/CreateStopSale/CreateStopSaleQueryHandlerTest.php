<?php


namespace App\Tests\test\Unit\Distribucion\StopSales\Application\StopSale;


use Distribution\BranchOffice\Domain\BranchOfficeCollection;
use Distribution\BranchOffice\Domain\BranchOfficeRepository;
use Distribution\Country\Domain\CountryCollection;
use Distribution\Country\Domain\CountryRepository;
use Distribution\Delegation\Domain\BranchCollection;
use Distribution\Delegation\Domain\BranchRepository;
use Distribution\Group\Domain\CarGroupCollection;
use Distribution\Group\Domain\CarGroupRepository;
use Distribution\Partner\Domain\PartnerCollection;
use Distribution\Partner\Domain\PartnerRepository;
use Distribution\StopSales\Application\StopSale\CreateStopSale\CreateStopSaleQuery;
use Distribution\StopSales\Application\StopSale\CreateStopSale\CreateStopSaleQueryHandler;
use Distribution\Zone\Domain\ZoneCollection;
use Distribution\Zone\Domain\ZoneRepository;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class CreateStopSaleQueryHandlerTest extends TestCase
{
    private $stopSale;

    protected function setUp()
    {
        $this->stopSale = new CreateStopSaleQueryHandler(
            $this->createMock(CarGroupRepository::class),
            $this->createMock(BranchRepository::class),
            $this->createMock(CountryRepository::class),
            $this->createMock(ZoneRepository::class),
            $this->createMock(BranchOfficeRepository::class),
            $this->createMock(PartnerRepository::class)
        );
    }

    /** @test */
    public function create_stop_sale_success(): void
    {
        $stopSale = $this->stopSale->handle(new CreateStopSaleQuery());
        $this->assertInstanceOf(BranchCollection::class, $stopSale->getDelegationCollection());
        $this->assertInstanceOf(CountryCollection::class, $stopSale->getCountryCollection());
        $this->assertInstanceOf(ZoneCollection::class, $stopSale->getZoneCollection());
        $this->assertInstanceOf(CarGroupCollection::class, $stopSale->getGroupCollection());
        $this->assertInstanceOf(BranchOfficeCollection::class, $stopSale->getBranchOfficeCollection());
        $this->assertInstanceOf(PartnerCollection::class, $stopSale->getPartnerCollection());
    }
}