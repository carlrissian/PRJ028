<?php


namespace App\Tests\test\Unit\Distribucion\Acriss\Domain;


use Distribution\Acriss\Domain\Acriss;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class AcrissTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $acriss = new Acriss(1, 'name');
        $this->assertEquals(1, $acriss->getId());
        $this->assertEquals('name', $acriss->getName());
    }
}