<?php
declare(strict_types=1);

namespace Distribution\CommercialGroupTranslations\Application\UpdateCommercialGroupTranslations;

class UpdateCommercialGroupTranslationsCommand
{
    /**
     * @var int
     */
    private int $id;
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
    private bool $default;
    /**
     * var int
     */
    private $userId;

    /**
     * @param int $id
     * @param int $commercialGroupId
     * @param int $languageId
     * @param string $languageCode
     * @param string $translation
     * @param bool $default
     * @param $userId
     */
    public function __construct(int $id, int $commercialGroupId, int $languageId, string $languageCode, string $translation, bool $default, $userId)
    {
        $this->id = $id;
        $this->commercialGroupId = $commercialGroupId;
        $this->languageId = $languageId;
        $this->languageCode = $languageCode;
        $this->translation = $translation;
        $this->default = $default;
        $this->userId = $userId;
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
    public function isDefault(): bool
    {
        return $this->default;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }


}