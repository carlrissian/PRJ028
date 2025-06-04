<?php


namespace App\Tests\test\Unit\Distribucion\Movements\Application\Search\IndexMovement;


use Distribution\BranchOffice\Domain\BranchOfficeCollection;
use Distribution\BranchOffice\Domain\BranchOfficeRepository;
use Distribution\Movement\Application\Search\IndexMovements\IndexMovementQuery;
use Distribution\Movement\Application\Search\IndexMovements\IndexMovementQueryHandler;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class IndexMovementQueryHandlerTest extends TestCase
{
    private $movement;

    protected function setUp()
    {
        $this->movement = new IndexMovementQueryHandler(
          $this->createMock(BranchOfficeRepository::class)
        );
    }

    /** @test */
    public function insert_movements_success(): void
    {
        $mov = $this->movement->handle(new indexMovementQuery());
        $this->assertInstanceOf(BranchOfficeCollection::class, $mov->getBranchOfficeCollection());
    }
}