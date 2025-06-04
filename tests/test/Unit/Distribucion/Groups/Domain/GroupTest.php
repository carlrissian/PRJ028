<?php


namespace App\Tests\test\Unit\Distribucion\Groups\Domain;


use Distribution\Group\Domain\CarGroup;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class GroupTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $group = new CarGroup(1, 'name');
        $this->assertEquals(1, $group->getId());
        $this->assertEquals('name', $group->getName());
    }
}