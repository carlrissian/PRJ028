<?php


namespace App\Tests\test\Unit\Distribucion\Movements\Application\Search\GetMovement;


use Distribution\Movement\Application\Search\GetMovements\GetMovementsQuery;
use Distribution\Movement\Application\Search\GetMovements\GetMovementsQueryHandler;
use Distribution\Movement\Domain\MovementRepository;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class GetMovementsQueryHandlerTest extends TestCase
{
    private $movement;

    protected function setUp()
    {
        $this->movement = new GetMovementsQueryHandler(
            $this->createMock(MovementRepository::class)
        );
    }

    /** @test */
    public function insert_movements_success(): void
    {
        $movement = $this->movement->handle(new GetMovementsQuery(DateTimeValueObject::createFromDateTime(new \DateTime()), DateTimeValueObject::createFromDateTime(new \DateTime())));
        $this->assertIsArray($movement->getMovements());
    }
}