<?php


namespace App\Tests\test\Unit\Distribucion\Location\Domain;


use Distribution\Location\Domain\Location;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class LocationTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $location = new Location('1', '1', '1', '1', '1');
        $this->assertEquals(1, $location->id());
        $this->assertEquals(1, $location->branchOfficeId());
        $this->assertEquals(1, $location->delegationId());
        $this->assertEquals(1, $location->zoneId());
        $this->assertEquals(1, $location->countryId());
    }
}