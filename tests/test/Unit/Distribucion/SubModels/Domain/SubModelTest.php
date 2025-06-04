<?php


namespace App\Tests\test\Unit\Distribucion\SubModels\Domain;


use Distribution\SubModel\Domain\SubModel;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class SubModelTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $modal = new SubModel(1, 'name');
        $this->assertEquals(1, $modal->getId());
        $this->assertEquals('name', $modal->getName());
    }
}