<?php


namespace App\Tests\test\Unit\Distribucion\Availability\Application\ShowAvailability;


use Distribution\Availability\Application\ShowAvailability\ShowAvailabilityQuery;
use Distribution\Availability\Application\ShowAvailability\ShowAvailabilityQueryHandler;
use Distribution\Availability\Domain\AvailabilityRepository;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class ShowAvailabilityQueryHandlerTest extends TestCase
{
    private $showAvaibility;

    protected function setUp()
    {
        $this->showAvaibility = new ShowAvailabilityQueryHandler(
          $this->createMock(AvailabilityRepository::class)
        );
    }

    /** @test */
    public function get_show_avaibility(): void
    {
        $availibilityCollection = $this->showAvaibility->handle(new ShowAvailabilityQuery(DateTimeValueObject::createFromDateTime(new \DateTime()), DateTimeValueObject::createFromDateTime(new \DateTime()), [], [], [], [], [], [], []));
        $this->assertIsArray($availibilityCollection->getAvailabilityArray());
    }
}