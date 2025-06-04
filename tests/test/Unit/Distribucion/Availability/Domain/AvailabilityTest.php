<?php


namespace App\Tests\test\Unit\Distribucion\Availability\Domain;


use Distribution\Availability\Domain\Availability;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class AvailabilityTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $availibility = new Availability([]);
        $this->assertEquals([], $availibility->getReport());
    }

}