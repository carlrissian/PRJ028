<?php


namespace App\Tests\test\Unit\Distribucion\Availability\Application\HourAvailability;


use Distribution\Availability\Application\HourAvailabilityFilter\HourAvailabilityFilterQuery;
use Distribution\Availability\Application\HourAvailabilityFilter\HourAvailabilityFilterQueryHandler;
use Distribution\BranchOffice\Domain\BranchOfficeCollection;
use Distribution\BranchOffice\Domain\BranchOfficeRepository;
use Distribution\Group\Domain\CarGroupCollection;
use Distribution\Group\Domain\CarGroupRepository;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class HourAvailabilityFilterQueryHandlerTest extends TestCase
{
    private $hours;

    protected function setUp()
    {
        $this->hours = new HourAvailabilityFilterQueryHandler(
            $this->createMock(BranchOfficeRepository::class),
            $this->createMock(CarGroupRepository::class)
        );
    }

    /** @test */
    public function get_hour_availability()
    {
        $response = $this->hours->handle(new HourAvailabilityFilterQuery());
        $this->assertInstanceOf(BranchOfficeCollection::class, $response->getBranchOfficeCollection());
        $this->assertInstanceOf(CarGroupCollection::class, $response->getGroupCollection());
    }
}