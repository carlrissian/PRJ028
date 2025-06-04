<?php


namespace App\Tests\test\Unit\Distribucion\Movements\Application\Carrier\CreateMovementExcel;


use Distribution\BranchOffice\Domain\BranchOfficeRepository;
use Distribution\Vehicle\Domain\VehicleRepository;
use Distribution\Brand\Domain\BrandRepository;
use Distribution\Model\Domain\ModelRepository;
use Distribution\Movement\Application\Carrier\CreateMovementExcel\CreateMovementExcelQuery;
use Distribution\Movement\Application\Carrier\CreateMovementExcel\CreateMovementExcelQueryHandler;
use Distribution\ShoppingType\Domain\ResaleCodeRepository;
use Distribution\VehicleStatus\Domain\StatusRepository;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class CreateMovementExcelQueryHandlerTest extends TestCase
{
    private $movementExcel;

    protected function setUp()
    {
        $this->movementExcel = new CreateMovementExcelQueryHandler(
            $this->createMock(VehicleRepository::class),
            $this->createMock(BrandRepository::class),
            $this->createMock(ModelRepository::class),
            $this->createMock(BranchOfficeRepository::class),
            $this->createMock(StatusRepository::class),
            $this->createMock(ResaleCodeRepository::class)
        );
    }

    /** @test */
    public function create_movements_excel(): void
    {
        $vehicles = $this->movementExcel->handle(new CreateMovementExcelQuery([]));
        $this->assertIsArray($vehicles->getVehicles());
    }
}