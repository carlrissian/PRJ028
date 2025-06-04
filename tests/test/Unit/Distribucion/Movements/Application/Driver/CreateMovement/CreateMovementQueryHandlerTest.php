<?php


namespace App\Tests\test\Unit\Distribucion\Movements\Application\Driver\CreateMovement;


use Distribution\Acriss\Infrastructure\AcrissRepositoryFake;
use Distribution\BranchOffice\Domain\BranchOfficeCollection;
use Distribution\BranchOffice\Infrastructure\BranchOfficeRepositoryFake;
use Distribution\CarClass\Infrastructure\CarClassRepositoryFake;
use Distribution\Vehicle\Infrastructure\VehicleRepositoryFake;
use Distribution\User\Domain\UserRepository;
use Distribution\Group\Infrastructure\CarGroupRepositoryFake;
use Distribution\Brand\Infrastructure\BrandRepositoryFake;
use Distribution\Model\Infrastructure\ModelRepositoryFake;
use Distribution\Movement\Application\Driver\CreateMovement\CreateMovementQuery;
use Distribution\Movement\Application\Driver\CreateMovement\CreateMovementQueryHandler;
use Distribution\MovementType\Domain\MovementTypeCollection;
use Distribution\MovementType\Domain\MovementTypeRepository;
use Distribution\Supplier\Domain\ProviderCollection;
use Distribution\Supplier\Domain\SupplierRepository;
use Distribution\VehicleStatus\Infrastructure\StatusRepositoryFake;
use Distribution\SubModel\Infrastructure\SubModelRepositoryFake;
use Distribution\VehicleSubStatus\Infrastructure\VehicleSubStatusRepositoryFake;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class CreateMovementQueryHandlerTest extends TestCase
{
    private $movement;

    protected function setUp()
    {
        $this->movement = new CreateMovementQueryHandler(
            $this->createMock(SupplierRepository::class),
            $this->createMock(MovementTypeRepository::class),
            new BranchOfficeRepositoryFake(),
            $this->createMock(UserRepository::class),
            new VehicleRepositoryFake(),
            new CarGroupRepositoryFake(),
            new CarClassRepositoryFake(),
            new AcrissRepositoryFake(),
            new BrandRepositoryFake(),
            new ModelRepositoryFake(),
            new SubModelRepositoryFake(),
            new StatusRepositoryFake(),
            new VehicleSubStatusRepositoryFake()
        );
    }

    /** @test */
    public function insert_movements_success(): void
    {
        $vehicles = $this->movement->handle(new CreateMovementQuery('111', '111'));
        $this->assertIsArray($vehicles->vehicle());
        $this->assertIsArray($vehicles->getUserCollection());
        $this->isInstanceOf(ProviderCollection::class, $vehicles->getProviderCollection());
        $this->isInstanceOf(MovementTypeCollection::class, $vehicles->getMovementTypeCollection());
        $this->isInstanceOf(BranchOfficeCollection::class, $vehicles->getBranchOfficeCollection());
    }
}