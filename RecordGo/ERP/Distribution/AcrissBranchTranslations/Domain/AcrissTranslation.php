<?php

namespace Distribution\AcrissBranchTranslations\Domain;

/**
 * Class AcrissTranslation
 * @package Distribution\AcrissTranslations\Domain
 */
final class AcrissTranslation
{
    /**
     * @var integer|null
     */
    private ?int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var Language
     */
    private Language $language;

    /**
     * @var bool|null
     */
    private ?bool $byDefault;

    /**
     * AcrissTranslation constructor
     *
     * @param integer|null $id
     * @param string $name
     * @param Language $language
     * @param bool|null $byDefault
     */
    private function __construct(
        ?int $id,
        string $name,
        Language $language,
        ?bool $byDefault
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->language = $language;
        $this->byDefault = $byDefault;
    }

    /**
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }

    /**
     * @return bool|null
     */
    public function isByDefault(): ?bool
    {
        return $this->byDefault;
    }


    /**
     * @param integer|null $id
     * @param string $name
     * @param Language $language
     * @param boolean $byDefault
     */
    public static function create(
        ?int $id,
        string $name,
        Language $language,
        ?bool $byDefault = null
    ): self {
        return new self(
            $id,
            $name,
            $language,
            $byDefault
        );
    }

    /**
     * @param array|null $acrissTranslationArray
     * @return self
     */
    public static function createFromArray(?array $acrissTranslationArray): self
    {
        return self::create(
            intval($acrissTranslationArray['ID']),
            $acrissTranslationArray['ACRISSTRANSNAME'],
            isset($acrissTranslationArray['LANGUAGE']) ? Language::createFromArray($acrissTranslationArray['LANGUAGE']) : null,
            isset($acrissTranslationArray['BYDEFAULT']) ? filter_var($acrissTranslationArray['BYDEFAULT'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : false
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'ACRISSTRANSNAME' => $this->getName(),
            'LANGUAGE' => $this->getLanguage()->toArray(),
            'BYDEFAULT' => $this->isByDefault() !== null ? ($this->isByDefault() ? 1 : 0) : null,
        ];
    }
}
