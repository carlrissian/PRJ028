<?php


namespace App\Tests\test\Unit\Distribucion\StopSales\Application\OneWay\CreateOneWay;


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
use Distribution\SpecialField\Domain\SpecialFieldCollection;
use Distribution\SpecialField\Domain\SpecialFieldRepository;
use Distribution\StopSales\Application\OneWay\CreateOneWay\CreateOneWayQuery;
use Distribution\StopSales\Application\OneWay\CreateOneWay\CreateOneWayQueryHandler;
use Distribution\Zone\Domain\ZoneCollection;
use Distribution\Zone\Domain\ZoneRepository;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class CreateOneWayQueryHandlerTest extends TestCase
{
    private $oneWay;

    protected function setUp()
    {
        $this->oneWay = new CreateOneWayQueryHandler(
            $this->createMock(CarGroupRepository::class),
            $this->createMock(PartnerRepository::class),
            $this->createMock(ZoneRepository::class),
            $this->createMock(CountryRepository::class),
            $this->createMock(BranchRepository::class),
            $this->createMock(BranchOfficeRepository::class),
            $this->createMock(SpecialFieldRepository::class)
        );
    }

    /** @test */
    public function create_one_way_success(): void
    {
        $oneWay = $this->oneWay->handle(new CreateOneWayQuery());
        $this->assertInstanceOf(CarGroupCollection::class, $oneWay->getGroupCollection());
        $this->assertInstanceOf(PartnerCollection::class, $oneWay->getPartnerCollection());
        $this->assertInstanceOf(ZoneCollection::class, $oneWay->getZoneCollection());
        $this->assertInstanceOf(CountryCollection::class, $oneWay->getCountryCollection());
        $this->assertInstanceOf(BranchCollection::class, $oneWay->getDelegationCollection());
        $this->assertInstanceOf(BranchOfficeCollection::class, $oneWay->getBranchOfficeCollection());
        $this->assertInstanceOf(SpecialFieldCollection::class, $oneWay->getSpecialFieldCollection());
    }
}