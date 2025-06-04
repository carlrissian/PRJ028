<?php


namespace App\Tests\test\Unit\Distribucion\Delegations\Domain;


use Distribution\Delegation\Domain\Branch;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class DelegationTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $delegation = new Branch(1, 'Castellón', 'true', 1);
        $this->assertEquals(1, $delegation->getId());
        $this->assertEquals('Castellón', $delegation->getName());
        $this->assertEquals('true', $delegation->getState());
        $this->assertEquals(1, $delegation->getIdOrganizationZone());
    }
}