<?php

namespace Distribution\RentalAgreement\Domain;

class Acriss
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $commercialName;

    /**
     * Acriss constructor.
     * 
     * @param int $id
     * @param string|null $name
     * @param string|null $commercialName
     */
    public function __construct(int $id, ?string $name = null, ?string $commercialName = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->commercialName = $commercialName;
    }

    /**
     * @return int
     */
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    final public function getCommercialName(): ?string
    {
        return $this->commercialName;
    }


    /**
     * @param array $acrissArray
     * @return self
     */
    public static function createFromArray(array $acrissArray): self
    {
        return new self(
            intval($acrissArray['ID']),
            $acrissArray['ACRISSCODE'] ?? null,
            $acrissArray['COMMERCIALNAME'] ?? null
        );
    }
}
