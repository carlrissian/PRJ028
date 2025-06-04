<?php

declare(strict_types=1);

namespace Distribution\Planning\Domain;

class MotorizationType
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $acrissLetter;

    /**
     * MotorizationType constructor.
     * 
     * @param int $id
     * @param string|null $name
     * @param string|null $acrissLetter
     */
    public function __construct(
        int $id,
        ?string $name = null,
        ?string $acrissLetter = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->acrissLetter = $acrissLetter;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getAcrissLetter(): ?string
    {
        return $this->acrissLetter;
    }

}
