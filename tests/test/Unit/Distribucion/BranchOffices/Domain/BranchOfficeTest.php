<?php


namespace App\Tests\test\Unit\Distribucion\BranchOffices\Domain;


use Distribution\BranchOffice\Domain\BranchOffice;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class BranchOfficeTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $branchOffice = new BranchOffice(1, 'name');
        $this->assertEquals(1, $branchOffice->getId());
        $this->assertEquals('name', $branchOffice->getName());
    }
}