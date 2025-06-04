<?php


namespace App\Tests\test\Unit\Distribucion\Marks\Domain;


use Distribution\Brand\Domain\Brand;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class BrandTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $mark = new Brand(1, 'name');
        $this->assertEquals(1, $mark->getId());
        $this->assertEquals('name', $mark->getName());
    }
}