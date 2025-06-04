<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


use Shared\Domain\User;
use Shared\Domain\ValueObject\DateTimeValueObject;

class VehicleDelete
{
    /**
     * @var User|null
     */
    private ?User $creationUser;
    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $creationDate;


    /**
     * VehicleDelete constructor.
     * @param User|null $creationUser
     * @param DateTimeValueObject|null $creationDate
     */
    public function __construct(?User $creationUser, ?DateTimeValueObject $creationDate)
    {
        $this->creationUser = $creationUser;
        $this->creationDate = $creationDate;
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


}