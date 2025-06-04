<?php


namespace App\Tests\test\Unit\Distribucion\Location\Application;



use Distribution\BranchOffice\Domain\BranchOfficeRepository;
use Distribution\Country\Domain\CountryRepository;
use Distribution\Delegation\Domain\BranchRepository;
use Distribution\Location\Application\GetLocationQuery;
use Distribution\Location\Application\GetLocationQueryHandler;
use Distribution\Location\Domain\LocationRepository;
use Distribution\Zone\Domain\ZoneRepository;
use Symfony\Bundle\TwigBundle\Tests\TestCase;


class GetLocationQueryHandlerTest extends TestCase
{
    private $location;

    protected function setUp()
    {
        $this->location = new GetLocationQueryHandler(
            $this->createMock(LocationRepository::class),
            $this->createMock(BranchOfficeRepository::class),
            $this->createMock(BranchRepository::class),
            $this->createMock(ZoneRepository::class),
            $this->createMock(CountryRepository::class)
        );
    }

    /** @test */
    public function get_list_location(): void
    {
        $locations = $this->location->handle(new GetLocationQuery());
        $this->assertIsArray($locations->getLocation());
    }

}
