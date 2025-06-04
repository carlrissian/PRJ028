<?php


namespace App\Tests\test\Unit\Distribucion\SpecialFields\Domain;


use Distribution\SpecialField\Domain\SpecialField;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class SpecialFieldTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $special = new SpecialField(1, 'name');
        $this->assertEquals(1, $special->getId());
        $this->assertEquals('name', $special->getName());
    }
}