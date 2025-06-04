<?php


namespace App\Tests\test\Unit\Distribucion\MovementTypes\Domain;


use Distribution\MovementType\Domain\MovementType;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class MovementTypeTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $movementType = new MovementType(1, 'name');
        $this->assertEquals(1, $movementType->getId());
        $this->assertEquals('name', $movementType->getName());
    }
}