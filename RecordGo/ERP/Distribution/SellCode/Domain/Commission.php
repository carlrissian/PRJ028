<?php

namespace Distribution\SellCode\Domain;

class Commission
{
    /**
     * @var SellCodeAccountType
     */
    private $sellCodeAccountType;
    /**
     * @var Commissionable|null
     */
    private $commissionable;

    /**
     * Commission constructor.
     * @param SellCodeAccountType $sellCodeAccountType
     * @param Commissionable|null $commissionable
     */
    public function __construct(SellCodeAccountType $sellCodeAccountType, ?Commissionable $commissionable)
    {
        $this->sellCodeAccountType = $sellCodeAccountType;
        $this->commissionable = $commissionable;
    }

    /**
     * @return SellCodeAccountType
     */
    public function getSellCodeAccountType(): SellCodeAccountType
    {
        return $this->sellCodeAccountType;
    }

    /**
     * @return Commissionable|null
     */
    public function getCommissionable(): ?Commissionable
    {
        return $this->commissionable;
    }


    /**
     * @param array $commissionArray
     * @return self
     */
    public static function createFromArray(array $commissionArray): self
    {
        return new self(
            isset($commissionArray['ACCOUNTTYPEID']) ? SellCodeAccountType::createFromArray($commissionArray) : null,
            isset($commissionArray['COMMISION']) && isset($commissionArray['COMMISIONTO']) ? Commissionable::createFromArray($commissionArray) : null,
        );
    }
}
