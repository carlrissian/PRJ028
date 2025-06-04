<?php


namespace App\Tests\test\Unit\Distribucion\Movements\Domain;


use Distribution\Movement\Domain\Movement;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class MovementTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $date = new \DateTime();
        $movement = new Movement(DateTimeValueObject::createFromDateTime($date), DateTimeValueObject::createFromDateTime($date), '1', '1', '1', '1', '1');
        $this->assertEquals(DateTimeValueObject::createFromDateTime($date), $movement->getDateStart());
        $this->assertEquals(DateTimeValueObject::createFromDateTime($date), $movement->getDateEnd());
        $this->assertEquals(1, $movement->getChassis());
        $this->assertEquals(1, $movement->getRequestName());
        $this->assertEquals(1, $movement->getLicensePlate());
        $this->assertEquals(1, $movement->getBranchOrigin());
        $this->assertEquals(1, $movement->getBranchDestination());

    }
}