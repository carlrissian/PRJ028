<?php


namespace App\Tests\test\Unit\Distribucion\Zones\Domain;


use Distribution\Zone\Domain\Zone;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class ZoneTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $zones = new Zone('name', true, 1);
        $this->assertEquals('name', $zones->getName());
        $this->assertIsBool($zones->isInternal());
        $this->assertEquals(1, $zones->getId());
    }
}