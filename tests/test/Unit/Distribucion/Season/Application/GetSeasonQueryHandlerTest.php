<?php


namespace App\Tests\test\Unit\Distribucion\Season\Application;


use Distribution\BranchOffice\Domain\BranchOfficeRepository;
use Distribution\Country\Domain\CountryRepository;
use Distribution\Delegation\Domain\BranchRepository;
use Distribution\Location\Application\GetLocationQuery;
use Distribution\Location\Application\GetLocationQueryHandler;
use Distribution\Location\Domain\LocationRepository;
use Distribution\Zone\Infrastructure\ZoneRepositoryFake;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class GetSeasonQueryHandlerTest extends TestCase
{
    private $getSeasonQueryHandler;

    protected function setUp()
    {
        $this->getSeasonQueryHandler = new GetLocationQueryHandler(
          $this->createMock(LocationRepository::class),
          $this->createMock(BranchOfficeRepository::class),
          $this->createMock(BranchRepository::class),
          $this->createMock(ZoneRepositoryFake::class),
          $this->createMock(CountryRepository::class)
        );
    }

    /** @test */
    public function get_list_season(): void
    {
        $vehicles = $this->getSeasonQueryHandler->handle(new GetLocationQuery());
        $this->assertIsArray($vehicles->getLocation());
    }
}