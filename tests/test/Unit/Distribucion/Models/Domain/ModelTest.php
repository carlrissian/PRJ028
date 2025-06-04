<?php


namespace Distribution\Model\Domain;


use Symfony\Bundle\TwigBundle\Tests\TestCase;

class ModelTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $model = new Model(1, 'name');
        $this->assertEquals(1, $model->getId());
        $this->assertEquals('name', $model->getName());
    }
}