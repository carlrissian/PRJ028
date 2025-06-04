<?php


namespace App\Tests\test\Unit\Distribucion\CarClass\Domain;


use Distribution\CarClass\Domain\CarClass;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class CarClassTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $carClass = new CarClass(1, 'name');
        $this->assertEquals(1, $carClass->getId());
        $this->assertEquals('name', $carClass->getName());
    }
}