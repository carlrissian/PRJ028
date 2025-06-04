<?php

declare(strict_types=1);

namespace Distribution\AcrissType\Domain;

use JsonSerializable;

/**
 * Class AcrissSecondLetter
 * @package Distribution\AcrissSecondLetter\Domain
 */
class AcrissType implements JsonSerializable
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var null|string
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $acrissLetter;

    /**
     * @param int $id
     * @param string|null $name
     * @param string|null $acrissLetter
     */
    public function __construct(int $id, ?string $name = null, ?string $acrissLetter = null)
    {
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
     * @return string
     */
    public function getAcrissLetter(): ?string
    {
        return $this->acrissLetter;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }


    /**
     * @param array|null $acrissTypeArray
     * @return AcrissType
     */
    public static function createFromArray(?array $acrissTypeArray): AcrissType
    {
        return new self(
            intval($acrissTypeArray['ID']),
            $acrissTypeArray['CARTYPENAME'] ?? null,
            $acrissTypeArray['ACRISS1LETTER'] ?? null
        );
    }
}
