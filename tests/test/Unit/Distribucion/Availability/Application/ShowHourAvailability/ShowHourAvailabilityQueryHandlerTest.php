<?php


namespace App\Tests\test\Unit\Distribucion\Availability\Application\ShowHourAvailability;


use Distribution\Availability\Application\ShowHourAvailability\ShowHourAvailabilityQuery;
use Distribution\Availability\Application\ShowHourAvailability\ShowHourAvailabilityQueryHandler;
use Distribution\Availability\Domain\HourAvailabilityRepository;
use Distribution\BranchOffice\Domain\BranchOfficeCollection;
use Distribution\BranchOffice\Domain\BranchOfficeRepository;
use Distribution\Group\Domain\CarGroupCollection;
use Distribution\Group\Domain\CarGroupRepository;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class ShowHourAvailabilityQueryHandlerTest extends TestCase
{
    private $hour;

    protected function setUp()
    {
        $this->hour = new ShowHourAvailabilityQueryHandler(
            $this->createMock(HourAvailabilityRepository::class), $this->createMock(BranchOfficeRepository::class), $this->createMock(CarGroupRepository::class)
        );
    }

    /** @test */
    public function get_show_hour_availability()
    {
        $response = $this->hour->handle(new ShowHourAvailabilityQuery('111', '111', '111', '111'));
        $this->assertIsArray($response->getHourAvailabilityArray());
        $this->assertInstanceOf(BranchOfficeCollection::class, $response->getBranchOfficeCollection());
        $this->assertInstanceOf(CarGroupCollection::class, $response->getGroupCollection());
    }
}