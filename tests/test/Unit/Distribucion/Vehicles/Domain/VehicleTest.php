<?php


namespace App\Tests\test\Unit\Distribucion\Vehicles\Domain\VehicleTest;


use Distribution\Vehicle\Domain\Vehicle;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class VehicleTest extends TestCase
{
    /** @test */
    public function should_be_correct(): void
    {
        $date = new \DateTime();
        $vehicle = new Vehicle('1', '1', '1', '1', DateTimeValueObject::createFromDateTime($date), '1', DateTimeValueObject::createFromDateTime($date),
            DateTimeValueObject::createFromDateTime($date), '1',
            '1', '1', '1', '1', '1', '1', '1', '1', '1', '1',
            '1', '1', '1', '1', '1');
        $this->assertEquals('1', $vehicle->id());
        $this->assertEquals('1', $vehicle->licensePlate());
        $this->assertEquals('1', $vehicle->kilometers());
        $this->assertEquals('1', $vehicle->blockage());
        $this->assertEquals(DateTimeValueObject::createFromDateTime($date), $vehicle->dateBlockage());
        $this->assertEquals('1', $vehicle->chassis());
        $this->assertEquals(DateTimeValueObject::createFromDateTime($date), $vehicle->endAvailabilityDate());
        $this->assertEquals(DateTimeValueObject::createFromDateTime($date), $vehicle->endRentalDate());
        $this->assertEquals('1', $vehicle->groupId());
        $this->assertEquals('1', $vehicle->countryId());
        $this->assertEquals('1', $vehicle->zoneId());
        $this->assertEquals('1', $vehicle->delegationId());
        $this->assertEquals('1', $vehicle->brandId());
        $this->assertEquals('1', $vehicle->modelId());
        $this->assertEquals('1', $vehicle->subModelId());
        $this->assertEquals('1', $vehicle->carClassId());
        $this->assertEquals('1', $vehicle->fuelId());
        $this->assertEquals('1', $vehicle->acrissId());
        $this->assertEquals('1', $vehicle->shoppingTypeId());
        $this->assertEquals('1', $vehicle->transmissionId());
        $this->assertEquals('1', $vehicle->stateId());
        $this->assertEquals('1', $vehicle->subStateId());
        $this->assertEquals('1', $vehicle->branchOfficeId());
        $this->assertEquals('1', $vehicle->placement());
    }
}