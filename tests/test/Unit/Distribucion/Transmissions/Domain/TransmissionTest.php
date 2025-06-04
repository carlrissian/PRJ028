<?php


namespace App\Tests\test\Unit\Distribucion\Transmissions\Domain;


use Distribution\Transmission\Domain\Transmission;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class TransmissionTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $transmission = new Transmission(1, 'name');
        $this->assertEquals(1, $transmission->getId());
        $this->assertEquals('name', $transmission->getName());
    }
}