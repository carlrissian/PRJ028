<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Domain;

use Shared\Utils\DataValidation;

/**
 * Class Translation
 * @package Distribution\CommercialGroup\Domain
 */
class Translation
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var int|null
     */
    private $languageId;

    /**
     * @var bool|null
     */
    private $default;

    /**
     * CommercialGroupTranslation constructor
     *
     * @param integer|null $id
     * @param string|null $name
     * @param integer|null $languageId
     * @param boolean|null $default
     */
    public function __construct(
        ?int $id,
        ?string $name,
        ?int $languageId,
        ?bool $default
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->languageId = $languageId;
        $this->default = $default;
    }

    /**
     * Get the value of id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the value of languageId
     *
     * @return int|null
     */
    public function getLanguageId(): ?int
    {
        return $this->languageId;
    }

    /**
     * Get the value of default
     *
     * @return bool|null
     */
    public function isDefault(): ?bool
    {
        return $this->default;
    }


    /**
     * @param array|null $translationArray
     * @return Translation
     */
    public static function createFromArray(?array $translationArray): Translation
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($translationArray, 'ID')),
            $helper->arrayExistOrNull($translationArray, 'SGTRANSNAME'),
            $helper->intOrNull($helper->arrayExistOrNull($translationArray, 'LENGUAGEID')),
            $helper->boolOrNull($helper->arrayExistOrNull($translationArray, 'DEFAULT'))
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'SGTRANSNAME' => $this->getName(),
            'LENGUAGEID' => $this->getLanguageId(),
            'DEFAULT' => (!is_null($this->isDefault())) ? ($this->isDefault() ? 1 : 0) : null,
        ];
    }
}
