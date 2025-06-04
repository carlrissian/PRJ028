<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

use Shared\Domain\User;
use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateTimeValueObject;

class DeliveryNote
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var int
     */
    private int $typeId;

    /**
     * @var string
     */
    private string $typeName;

    /**
     * @var string
     */
    private string $file;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $dateUpload;

    /**
     * @var User|null
     */
    private ?User $user;

    /**
     * DeliveryNote constructor.
     * 
     * @param int|null $id
     * @param int $typeId
     * @param string $typeName
     * @param string $file
     * @param DateTimeValueObject|null $dateUpload
     * @param User|null $user
     */
    public function __construct(
        ?int $id,
        int $typeId,
        string $typeName,
        string $file,
        ?DateTimeValueObject $dateUpload = null,
        ?User $user = null
    ) {
        $this->id = $id;
        $this->typeId = $typeId;
        $this->typeName = $typeName;
        $this->file = $file;
        $this->dateUpload = $dateUpload;
        $this->user = $user;
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
    public function getTypeId(): int
    {
        return $this->typeId;
    }

    /**
     * @param int $typeId
     * @return void
     */
    public function setTypeId(int $typeId): void
    {
        $this->typeId = $typeId;
    }

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        return $this->typeName;
    }

    /**
     * @param string $typeName
     * @return void
     */
    public function setTypeName(string $typeName): void
    {
        $this->typeName = $typeName;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file
     * @return void
     */
    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getDateUpload(): ?DateTimeValueObject
    {
        return $this->dateUpload;
    }

    /**
     * @param DateTimeValueObject|null $dateUpload
     * @return void
     */
    public function setDateUpload($dateUpload): void
    {
        $this->dateUpload = $dateUpload;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'PUDODOCTYPEID' => $this->getTypeId(),
            'PUDOPDF' => $this->getFile(),
            'CREATIONDATE' => ($this->getDateUpload()) ? Utils::formatStringDateTimeToOdataDate($this->getDateUpload()->__toString(), 'd/m/Y H:i:s') : null,
        ];
    }
}
