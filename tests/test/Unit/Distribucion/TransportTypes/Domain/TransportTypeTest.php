<?php


namespace App\Tests\test\Unit\Distribucion\TransportTypes\Domain;


use Distribution\TransportType\Domain\TransportType;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class TransportTypeTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $transportType = new TransportType(1, 'name');
        $this->assertEquals(1, $transportType->getId());
        $this->assertEquals('name', $transportType->getName());
    }
}