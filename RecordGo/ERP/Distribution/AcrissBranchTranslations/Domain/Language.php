<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Domain;

/**
 * Class Language
 * @package Distribution\AcrissTranslations\Domain
 */
class Language
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $code;

    /**
     * Language constrcutor.
     *
     * @param integer $id
     * @param string $name
     * @param string $code
     */
    public function __construct(
        int $id,
        string $name,
        string $code
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * @return integer
     */
    public function getId(): int
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
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }


    /**
     * @param array|null $languageArray
     * @return self
     */
    public static function createFromArray(?array $languageArray): self
    {
        return new self(
            intval($languageArray['ID']),
            $languageArray['LANGUAGESNAME'] ?? null,
            $languageArray['LANGUAGESDESCRIPTION'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'LANGUAGESDESCRIPTION' => $this->getCode(),
            'LANGUAGESNAME' => $this->getName(),
        ];
    }
}
