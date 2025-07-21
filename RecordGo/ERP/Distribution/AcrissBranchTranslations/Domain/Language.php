<?php

namespace Distribution\AcrissBranchTranslations\Domain;

/**
 * Class Language
 * @package Distribution\AcrissTranslations\Domain
 */
final class Language
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
    private string $iso;

    /**
     * Language constrcutor.
     *
     * @param integer $id
     * @param string $name
     * @param string $iso
     */
    public function __construct(
        int $id,
        string $name,
        string $iso
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->iso = $iso;
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
    public function getISO(): string
    {
        return $this->iso;
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
            'LANGUAGESNAME' => $this->getName(),
            'LANGUAGESDESCRIPTION' => $this->getISO(),
        ];
    }
}
