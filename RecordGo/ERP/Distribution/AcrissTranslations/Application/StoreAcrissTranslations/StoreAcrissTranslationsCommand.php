<?php

declare(strict_types=1);

namespace Distribution\AcrissTranslations\Application\StoreAcrissTranslations;

class StoreAcrissTranslationsCommand
{
    /**
     * @var int
     */
    private int $acrissId;

    /**
     * @var int
     */
    private int $branchId;

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
     * @param int $acrissId
     * @param int $branchId
     * @param int $languageId
     * @param string $languageCode
     * @param string $translation
     * @param bool $default
     * @param $userId
     */
    public function __construct(
        int $acrissId,
        int $branchId,
        int $languageId,
        string $languageCode,
        string $translation,
        bool $default,
        $userId
    ) {
        $this->acrissId = $acrissId;
        $this->branchId = $branchId;
        $this->languageId = $languageId;
        $this->languageCode = $languageCode;
        $this->translation = $translation;
        $this->default = $default;
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getAcrissId(): int
    {
        return $this->acrissId;
    }

    /**
     * @return int
     */
    public function getBranchId(): int
    {
        return $this->branchId;
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
