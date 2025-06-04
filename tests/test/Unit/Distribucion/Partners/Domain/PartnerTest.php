<?php


namespace App\Tests\test\Unit\Distribucion\Partners\Domain;


use Distribution\Partner\Domain\Partner;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class PartnerTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $partner = new Partner(1, 'name');
        $this->assertEquals(1, $partner->getId());
        $this->assertEquals('name', $partner->getName());
    }
}