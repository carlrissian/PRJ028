<?php

namespace Distribution\SellCode\Domain;

class PartnerType
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
     * PartnerType constructor.
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
     * @param array $partnerTypeArray
     * @return self
     */
    public static function createFromArray(array $partnerTypeArray): self
    {
        return new self(
            intval($partnerTypeArray['ID']),
            $partnerTypeArray['NAME'] ?? null
        );
    }
}
