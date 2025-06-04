<?php
declare(strict_types=1);


namespace Distribution\Planning\Application\StorePlanning;


class StorePlanningCommand
{

    /**
     * @var array
     */
    private array $vehiclesId;
    /**
     * @var array
     */
    private array $model;
    /**
     * @var array
     */
    private array $orPlan;
    /**
     * @var int
     */
    private int $validated;
    /**
     * @var int
     */
    private int $month;
    /**
     * @var int
     */
    private int $year;
    /**
     * @var array|null
     */
    private ?array $acrissSelected;

    /**
     * @param array $vehiclesId
     * @param array $model
     * @param array $orPlan
     * @param int $validated
     * @param int $month
     * @param int $year
     * @param array|null $acrissSelected
     */
    public function __construct(array $vehiclesId, array $model, array $orPlan, int $validated, int $month, int $year, ?array $acrissSelected = null)
    {
        $this->vehiclesId = $vehiclesId;
        $this->model = $model;
        $this->orPlan = $orPlan;
        $this->validated = $validated;
        $this->month = $month;
        $this->year = $year;
        $this->acrissSelected = $acrissSelected;
    }

    /**
     * @return array
     */
    public function getVehiclesId(): array
    {
        return $this->vehiclesId;
    }

    /**
     * @return array
     */
    public function getModel(): array
    {
        return $this->model;
    }

    /**
     * @return array
     */
    public function getOrPlan(): array
    {
        return $this->orPlan;
    }

    /**
     * @return int
     */
    public function isValidated(): int
    {
        return $this->validated;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return array|null
     */
    public function getAcrissSelected(): ?array
    {
        return $this->acrissSelected;
    }


}