<?php


namespace App\Tests\test\Unit\Distribucion\Season\Domain;


use Distribution\Season\Domain\Season;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class SeasonTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $season = new Season('1', '1', '1', '1', []);
        $this->assertEquals('1', $season->id());
        $this->assertEquals('1', $season->branchOfficeId());
        $this->assertEquals('1', $season->dateEnd());
        $this->assertEquals('1', $season->dateStart());
        $this->assertIsArray($season->groupsId());
    }
}