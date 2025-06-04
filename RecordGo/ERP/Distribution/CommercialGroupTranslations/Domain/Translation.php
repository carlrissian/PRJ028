<?php
declare(strict_types=1);


namespace Distribution\CommercialGroupTranslations\Domain;

use Shared\Domain\ValueObject\DateTimeValueObject;

/**
 * Class Translation
 * @package Distribution\CommercialGroupTranslations\Domain
 */
class Translation
{
    /**
     * @var int|null
     */
    private ?int $id;
    /**
     * @var int
     */
    private int $commercialGroupId;
    /**
     * @var int
     */
    private int $languageId;
    /**
     * @var string
     */
    private string $languageCode;
    /**
     * @var string
     */
    private string $translation;

    /**
     * @var bool
     */
    private bool $byDefault;
    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $creationDate;
    /**
     * @var int|null
     */
    private ?int $creationUser;
    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $updateDate;
    /**
     * @var int|null
     */
    private ?int $updateUser;

    /**
     * @param int|null $id
     * @param int $commercialGroupId
     * @param int $languageId
     * @param string $languageCode
     * @param string $translation
     * @param bool $byDefault
     * @param DateTimeValueObject|null $creationDate
     * @param int|null $creationUser
     * @param DateTimeValueObject|null $updateDate
     * @param int|null $updateUser
     */
    public function __construct(?int $id, int $commercialGroupId, int $languageId, string $languageCode, string $translation, bool $byDefault, ?DateTimeValueObject $creationDate = null, ?int $creationUser = null, ?DateTimeValueObject $updateDate = null, ?int $updateUser = null)
    {
        $this->id = $id;
        $this->commercialGroupId = $commercialGroupId;
        $this->languageId = $languageId;
        $this->languageCode = $languageCode;
        $this->translation = $translation;
        $this->byDefault = $byDefault;
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
    public function getCommercialGroupId(): int
    {
        return $this->commercialGroupId;
    }

    /**
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    /**
     * @return string
     */
    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    /**
     * @return string
     */
    public function getTranslation(): string
    {
        return $this->translation;
    }

    /**
     * @return bool
     */
    public function isByDefault(): bool
    {
        return $this->byDefault;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getCreationDate(): ?DateTimeValueObject
    {
        return $this->creationDate;
    }

    /**
     * @return int|null
     */
    public function getCreationUser(): ?int
    {
        return $this->creationUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getUpdateDate(): ?DateTimeValueObject
    {
        return $this->updateDate;
    }

    /**
     * @return int|null
     */
    public function getUpdateUser(): ?int
    {
        return $this->updateUser;
    }
}
