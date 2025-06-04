<?php


namespace App\Tests\test\Unit\Distribucion\ShoppingTypes\Domain;


use Distribution\ShoppingType\Domain\ResaleCode;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class ShoppingTypeTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $shopping = new ResaleCode(1, 'name');
        $this->assertEquals(1, $shopping->getId());
        $this->assertEquals('name', $shopping->getName());
    }
}