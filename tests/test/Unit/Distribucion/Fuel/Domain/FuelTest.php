<?php


namespace App\Tests\test\Unit\Distribucion\Fuel\Domain;


use Distribution\Fuel\Domain\Fuel;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class FuelTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $fuel = new Fuel(1, 'name');
        $this->assertEquals(1, $fuel->getId());
        $this->assertEquals('name', $fuel->getName());
    }
}