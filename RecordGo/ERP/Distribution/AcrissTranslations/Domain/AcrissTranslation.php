<?php

declare(strict_types=1);

namespace Distribution\AcrissTranslations\Domain;

use Shared\Utils\DataValidation;

/**
 * Class AcrissTranslation
 * @package Distribution\AcrissTranslations\Domain
 */
class AcrissTranslation
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var int
     */
    private int $acrissBranchId;

    /**
     * @var int
     */
    private int $languageId;

    /**
     * @var string
     */
    private string $translation;

    /**
     * @var bool
     */
    private bool $byDefault;

    /**
     * @param int|null $id
     * @param int $acrissBranchId
     * @param int $languageId
     * @param string $translation
     * @param bool $byDefault
     */
    public function __construct(
        ?int $id,
        int $acrissBranchId,
        int $languageId,
        string $translation,
        bool $byDefault
    ) {
        $this->id = $id;
        $this->acrissBranchId = $acrissBranchId;
        $this->languageId = $languageId;
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
    public function getAcrissBranchId(): int
    {
        return $this->acrissBranchId;
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
     * @param array|null $acrissTranslationArray
     * @return AcrissTranslation|null
     */
    public static function createFromArray(?array $acrissTranslationArray): ?AcrissTranslation
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($acrissTranslationArray, 'ID')),
            $helper->intOrNull($helper->arrayExistOrNull($acrissTranslationArray, 'ACRISSBRANCHID')),
            $helper->intOrNull($helper->arrayExistOrNull($acrissTranslationArray, 'LANGUAGEID')),
            $helper->arrayExistOrNull($acrissTranslationArray, 'ACRISSTRANSNAME'),
            $helper->boolOrNull($helper->arrayExistOrNull($acrissTranslationArray, 'BYDEFAULT'))
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'ACRISSBRANCHID' => $this->getAcrissBranchId(),
            'LANGUAGEID' => $this->getLanguageId(),
            'ACRISSTRANSNAME' => $this->getTranslation(),
            'BYDEFAULT' => $this->isByDefault() ? 1 : 0,
        ];
    }
}
