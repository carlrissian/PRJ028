<?php


namespace App\Tests\test\Unit\Distribucion\Availability\Application\DetailAvailability;


use Distribution\Availability\Application\DetailAvailability\DetailAvailabilityQuery;
use Distribution\Availability\Application\DetailAvailability\DetailAvailabilityQueryHandler;
use Distribution\Brand\Infrastructure\BrandRepositoryFake;
use Distribution\Vehicle\Infrastructure\VehicleRepositoryFake;
use Distribution\Model\Infrastructure\ModelRepositoryFake;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class DetailAvailabilityQueryHandlerTest extends TestCase
{
    private $availability;

    protected function setUp()
    {
        $this->availability = new DetailAvailabilityQueryHandler(
          new VehicleRepositoryFake(),
          new BrandRepositoryFake(),
          new ModelRepositoryFake()
        );
    }

    /** @test */
    public function get_detail_availability()
    {
        $response = $this->availability->handle(new DetailAvailabilityQuery());
        $this->assertIsArray($response->cars());
    }
}