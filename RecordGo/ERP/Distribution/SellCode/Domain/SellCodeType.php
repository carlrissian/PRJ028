<?php

namespace Distribution\SellCode\Domain;

class SellCodeType
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * SellCodeTypeController constructor.
     * 
     * @param int $id
     * @param string|null $name
     */
    public function __construct(int $id, ?string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
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
     * @param array $sellCodeTypeArray
     * @return self
     */
    public static function createFromArray(array $sellCodeTypeArray): self
    {
        return new self(
            intval($sellCodeTypeArray['ID']),
            $sellCodeTypeArray['NAME'] ?? null,
        );
    }
}
