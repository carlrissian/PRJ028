<?php
declare(strict_types=1);


namespace Distribution\Planning\Domain;

use Shared\Domain\User;
use Shared\Domain\ValueObject\DateTimeValueObject;

class Planning
{
    /**
     * @var int|null
     */
    private ?int $id;
    /**
     * @var int
     */
    private int $year;
    /**
     * @var int
     */
    private int $month;
    /**
     * Son las lineas del Planning
     * @var PlanningLineCollection
     */
    private PlanningLineCollection $planningLineCollection;
    /**
     * @var OrPlanPlanning|null
     */
    private ?OrPlanPlanning $orPlanPlanning;
    /**
     * @var User|null
     */
    private ?User $creationUser;
    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $creationDate;
    /**
     * @var User|null
     */
    private ?User $editionUser;
    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $editionDate;

    /**
     * Planning constructor.
     * @param int|null $id
     * @param int $year
     * @param int $month
     * @param PlanningLineCollection $planningLineCollection
     * @param OrPlanPlanning|null $orPlanPlanning
     * @param User|null $creationUser
     * @param DateTimeValueObject|null $creationDate
     * @param User|null $editionUser
     * @param DateTimeValueObject|null $editionDate
     */
    public function __construct(?int $id, int $year, int $month, PlanningLineCollection $planningLineCollection, ?OrPlanPlanning $orPlanPlanning, ?User $creationUser, ?DateTimeValueObject $creationDate, ?User $editionUser, ?DateTimeValueObject $editionDate)
    {
        $this->id = $id;
        $this->year = $year;
        $this->month = $month;
        $this->planningLineCollection = $planningLineCollection;
        $this->orPlanPlanning = $orPlanPlanning;
        $this->creationUser = $creationUser;
        $this->creationDate = $creationDate;
        $this->editionUser = $editionUser;
        $this->editionDate = $editionDate;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @return PlanningLineCollection
     */
    public function getPlanningLineCollection(): PlanningLineCollection
    {
        return $this->planningLineCollection;
    }

    /**
     * @return OrPlanPlanning|null
     */
    public function getOrPlanPlanning(): ?OrPlanPlanning
    {
        return $this->orPlanPlanning;
    }

    /**
     * @return User|null
     */
    public function getCreationUser(): ?User
    {
        return $this->creationUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getCreationDate(): ?DateTimeValueObject
    {
        return $this->creationDate;
    }

    /**
     * @return User|null
     */
    public function getEditionUser(): ?User
    {
        return $this->editionUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getEditionDate(): ?DateTimeValueObject
    {
        return $this->editionDate;
    }

}