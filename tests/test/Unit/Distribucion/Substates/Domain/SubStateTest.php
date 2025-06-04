<?php


namespace App\Tests\test\Unit\Distribucion\SubStates\Domain;


use Distribution\VehicleSubStatus\Domain\VehicleSubStatus;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class SubStateTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $substate = new VehicleSubStatus(1, 'name');
        $this->assertEquals(1, $substate->getId());
        $this->assertEquals('name', $substate->getName());
    }
}