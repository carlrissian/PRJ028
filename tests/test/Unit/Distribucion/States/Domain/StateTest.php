<?php


namespace App\Tests\test\Unit\Distribucion\States\Domain;


use Distribution\VehicleStatus\Domain\Status;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class StateTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $state = new Status(1, 'name');
        $this->assertEquals(1, $state->getId());
        $this->assertEquals('name', $state->getName());
    }
}