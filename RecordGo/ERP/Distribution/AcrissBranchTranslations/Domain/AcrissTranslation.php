<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Domain;

use Shared\Utils\DataValidation;

/**
 * Class AcrissTranslation
 * @package Distribution\AcrissTranslations\Domain
 */
class AcrissTranslation
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
     * @var bool
     */
    private bool $byDefault;

    /**
     * AcrissTranslation constructor
     *
     * @param integer|null $id
     * @param string $name
     * @param Language $language
     * @param boolean $byDefault
     */
    public function __construct(
        ?int $id,
        string $name,
        Language $language,
        bool $byDefault
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->language = $language;
        $this->byDefault = $byDefault;
    }

    /**
     * Get the value of id
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of language
     *
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }

    /**
     * Get the value of byDefault
     *
     * @return bool
     */
    public function isByDefault(): bool
    {
        return $this->byDefault;
    }


    /**
     * @param array|null $acrissTranslationArray
     * @return AcrissTranslation
     */
    public static function createFromArray(?array $acrissTranslationArray): AcrissTranslation
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($acrissTranslationArray, 'ID')),
            $helper->arrayExistOrNull($acrissTranslationArray, 'ACRISSTRANSNAME'),
            (isset($acrissTranslationArray['LANGUAGE'])) ? Language::createFromArray($acrissTranslationArray['LANGUAGE']) : null,
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
            'ACRISSTRANSNAME' => $this->getName(),
            'LANGUAGE' => $this->getLanguage()->toArray(),
            'BYDEFAULT' => $this->isByDefault() ? 1 : 0,
        ];
    }
}
