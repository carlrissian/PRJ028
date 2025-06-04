<?php


namespace App\Tests\test\Unit\Distribucion\Movements\Application\Carrier\CreateMovement;


use Distribution\BranchOffice\Domain\BranchOfficeCollection;
use Distribution\BranchOffice\Domain\BranchOfficeRepository;
use Distribution\Movement\Application\Carrier\CreateMovement\CreateMovementQuery;
use Distribution\Movement\Application\Carrier\CreateMovement\CreateMovementQueryHandler;
use Distribution\Supplier\Domain\ProviderCollection;
use Distribution\Supplier\Domain\SupplierRepository;
use Distribution\TransportType\Domain\TransportTypeCollection;
use Distribution\TransportType\Domain\TransportTypeRepository;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class CreateMovementQueryHandlerTest extends TestCase
{

    private $movement;

    protected function setUp()
    {
        $this->movement = new CreateMovementQueryHandler(
          $this->createMock(BranchOfficeRepository::class),
          $this->createMock(SupplierRepository::class),
          $this->createMock(TransportTypeRepository::class)
        );
    }

    /** @test */
    public function create_movement_success(): void
    {
        $movement = $this->movement->handle(new CreateMovementQuery());
        $this->assertInstanceOf(BranchOfficeCollection::class, $movement->getBranchOfficeCollection());
        $this->assertInstanceOf(ProviderCollection::class, $movement->getProviderCollection());
        $this->assertInstanceOf(TransportTypeCollection::class, $movement->getTransportTypeCollection());
    }
}