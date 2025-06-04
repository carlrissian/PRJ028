<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\CloseMovement;

class CloseMovementCommand
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $actualKms;

    /**
     * @var int|null
     */
    private ?int $tankActualOctaves;

    /**
     * @var float|null
     */
    private ?float $batteryActual;

    /**
     * @var float|null
     */
    private ?float $manualCost;

    /**
     * @var string
     */
    private string $actualUnloadDate;

    /**
     * @var string|null
     */
    private ?string $closingNotes;


    /**
     * CloseMovementCommand constructor.
     * 
     * @param int $id
     * @param int $actualKms
     * @param float|null $batteryActual
     * @param int|null $tankActualOctaves
     * @param float|null $manualCost
     * @param string|null $closingNotes
     * @param string $actualUnloadDate
     */
    public function __construct(
        int $id,
        int $actualKms,
        ?int $tankActualOctaves,
        ?float $batteryActual,
        ?float $manualCost,
        string $actualUnloadDate,
        ?string $closingNotes
    ) {
        $this->id = $id;
        $this->actualKms = $actualKms;
        $this->tankActualOctaves = $tankActualOctaves;
        $this->batteryActual = $batteryActual;
        $this->manualCost = $manualCost;
        $this->actualUnloadDate = $actualUnloadDate;
        $this->closingNotes = $closingNotes;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getActualKms(): int
    {
        return $this->actualKms;
    }

    /**
     * @return int|null
     */
    public function getTankActualOctaves(): ?int
    {
        return $this->tankActualOctaves;
    }

    /**
     * @return float|null
     */
    public function getBatteryActual(): ?float
    {
        return $this->batteryActual;
    }

    /**
     * @return int|float
     */
    public function getManualCost(): ?float
    {
        return $this->manualCost;
    }

    /**
     * @return string
     */
    public function getActualUnloadDate(): string
    {
        return $this->actualUnloadDate;
    }

    /**
     * @return string|null
     */
    public function getClosingNotes(): ?string
    {
        return $this->closingNotes;
    }
}
