<?php


namespace App\Tests\test\Unit\Distribucion\AnnualPlanning\Application;


use Distribution\AnnualPlanning\Application\ListAnnualPlanning\ListAnnualPlanningQuery;
use Distribution\AnnualPlanning\Application\ListAnnualPlanning\ListAnnualPlanningQueryHandler;
use Distribution\Group\Domain\CarGroupCollection;
use Distribution\Group\Domain\CarGroupRepository;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class IndexAnnualPlanningQueryHandlerTest extends TestCase
{
    private $planning;

    protected function setUp()
    {
        $this->planning = new ListAnnualPlanningQueryHandler(
          $this->createMock(CarGroupRepository::class)
        );
    }

    /** @test */
    public function get_planning()
    {
        $planings= $this->planning->handle(new ListAnnualPlanningQuery());
        $this->assertInstanceOf(CarGroupCollection::class, $planings->getGroupCollection());
    }
}