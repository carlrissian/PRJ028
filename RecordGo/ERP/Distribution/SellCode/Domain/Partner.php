<?php

namespace Distribution\SellCode\Domain;

class Partner
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $commercialName;

    /**
     * @var PartnerType|null
     */
    private $partnerType;

    /**
     * Partner constructor.
     * @param int $id
     * @param string|null $commercialName
     * @param PartnerType|null $partnerType
     */
    public function __construct(
        int $id,
        ?string $commercialName = null,
        ?PartnerType $partnerType = null
    ) {
        $this->id = $id;
        $this->commercialName = $commercialName;
        $this->partnerType = $partnerType;
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
    public function getCommercialName(): ?string
    {
        return $this->commercialName;
    }

    /**
     * @return PartnerType|null
     */
    public function getPartnerType(): ?PartnerType
    {
        return $this->partnerType;
    }


    /**
     * @param array $partnerArray
     * @return self
     */
    public static function createFromArray(array $partnerArray): self
    {
        return new self(
            intval($partnerArray['ID']),
            $partnerArray['COMMERCIALNAME'] ?? null,
            isset($partnerArray['PARTNERTYPE']) ? PartnerType::createFromArray($partnerArray['PARTNERTYPE']) : null
        );
    }
}
