<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


use Shared\Domain\ValueObject\FloatValueObject;

class VehicleRecords
{

    /**
     * @var int
     */
    private ?int $kilometersActual;
    /**
     * @var FloatValueObject|null
     */
    private ?FloatValueObject $batteryActual;
    /**
     * @var int|null
     */
    private ?int $tankActualOctaves;

    /**
     * VehicleRecords constructor.
     * @param int|null $kilometersActual
     * @param FloatValueObject|null $batteryActual
     * @param int|null $tankActualOctaves
     */
    public function __construct(?int $kilometersActual, ?FloatValueObject $batteryActual, ?int $tankActualOctaves)
    {
        $this->kilometersActual = $kilometersActual;
        $this->batteryActual = $batteryActual;
        $this->tankActualOctaves = $tankActualOctaves;
    }

    /**
     * @return int|null
     */
    public function getKilometersActual(): ?int
    {
        return $this->kilometersActual;
    }

    /**
     * @return FloatValueObject|null
     */
    public function getBatteryActual(): ?FloatValueObject
    {
        return $this->batteryActual;
    }

    /**
     * @return int|null
     */
    public function getTankActualOctaves(): ?int
    {
        return $this->tankActualOctaves;
    }

}