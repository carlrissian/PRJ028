<?php
declare(strict_types=1);


namespace Distribution\Acriss\Domain;

use JsonSerializable;

/**
 * Class Acriss
 * @package Distribution\Acriss\Domain
 */
class AcrissInferior implements JsonSerializable
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string|null
     */
    private ?string $acrissName;

    /**
     * @param int $id
     * @param string|null $acrissName
     */
    public function __construct(int $id, ?string $acrissName)
    {
        $this->id = $id;
        $this->acrissName = $acrissName;
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
    public function getAcrissName(): ?string
    {
        return $this->acrissName;
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
}
