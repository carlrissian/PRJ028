<?php


namespace Distribution\SellCode\Domain;

use Shared\Domain\User;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Shared\Utils\Utils;

class SellCode
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Partner
     */
    private $partner;

    /**
     * @var string|null
     */
    private $notes;

    /**
     * @var ProductCollection|null
     */
    private $productCollection;

    /**
     * @var MethodOfPayment
     */
    private $methodOfPayment;

    /**
     * @var Commission
     */
    private $commission;

    /**
     * @var SellCodeType
     */
    private $sellCodeType;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var User|null
     */
    private $creationUser;

    /**
     * @var DateTimeValueObject|null
     */
    private $creationDate;

    /**
     * @var User|null
     */
    private $editionUser;

    /**
     * @var DateTimeValueObject|null
     */
    private $editionDate;

    /**
     * SellCode constructor.
     * 
     * @param int|null $id
     * @param string $name
     * @param Partner $partner
     * @param string|null $notes
     * @param ProductCollection|null $productCollection
     * @param MethodOfPayment $methodOfPayment
     * @param Commission $commission
     * @param SellCodeType $sellCodeType
     * @param bool $active
     * @param User|null $creationUser
     * @param DateTimeValueObject|null $creationDate
     * @param User|null $editionUser
     * @param DateTimeValueObject|null $editionDate
     */
    public function __construct(
        ?int $id,
        string $name,
        Partner $partner,
        ?string $notes,
        ?ProductCollection $productCollection,
        MethodOfPayment $methodOfPayment,
        Commission $commission,
        SellCodeType $sellCodeType,
        bool $active,
        ?User $creationUser = null,
        ?DateTimeValueObject $creationDate = null,
        ?User $editionUser = null,
        ?DateTimeValueObject $editionDate = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->partner = $partner;
        $this->notes = $notes;
        $this->productCollection = $productCollection;
        $this->methodOfPayment = $methodOfPayment;
        $this->commission = $commission;
        $this->sellCodeType = $sellCodeType;
        $this->active = $active;
        $this->creationUser = $creationUser;
        $this->creationDate = $creationDate;
        $this->editionUser = $editionUser;
        $this->editionDate = $editionDate;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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
     * @return Partner
     */
    public function getPartner(): Partner
    {
        return $this->partner;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @return ProductCollection|null
     */
    public function getProductCollection(): ?ProductCollection
    {
        return $this->productCollection;
    }

    /**
     * @return MethodOfPayment
     */
    public function getMethodOfPayment(): MethodOfPayment
    {
        return $this->methodOfPayment;
    }

    /**
     * @return Commission
     */
    public function getCommission(): Commission
    {
        return $this->commission;
    }

    /**
     * @return SellCodeType
     */
    public function getSellCodeType(): SellCodeType
    {
        return $this->sellCodeType;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return User|null
     */
    public function getCreationUser(): ?User
    {
        return $this->creationUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getCreationDate(): ?DateTimeValueObject
    {
        return $this->creationDate;
    }

    /**
     * @return User|null
     */
    public function getEditionUser(): ?User
    {
        return $this->editionUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getEditionDate(): ?DateTimeValueObject
    {
        return $this->editionDate;
    }


    /**
     * @param array $sellCodeArray
     * @return self
     */
    public static function createFromArray(array $sellCodeArray): self
    {
        $productCollection = new ProductCollection([]);
        foreach ($sellCodeArray['PRODUCTARRAY']['results'] as $product) {
            $productCollection->add(Product::createFromArray($product));
        }

        return new self(
            intval($sellCodeArray['ID']),
            $sellCodeArray['SELLCODENAME'] ?? null,
            isset($sellCodeArray['PARTNER']) ? Partner::createFromArray($sellCodeArray['PARTNER']) : null,
            $sellCodeArray['SELLCODENOTES'] ?? null,
            $productCollection,
            isset($sellCodeArray['METHODOFPAYMENT']) ? MethodOfPayment::createFromArray($sellCodeArray['METHODOFPAYMENT']) : null,
            Commission::createFromArray($sellCodeArray),
            isset($sellCodeArray['SELLCODETYPE']) ? SellCodeType::createFromArray($sellCodeArray['SELLCODETYPE']) : null,
            filter_var($sellCodeArray['ACTIVE'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            isset($sellCodeArray['CREATIONUSER']) ? User::createFromArray($sellCodeArray['CREATIONUSER']) : null,
            isset($sellCodeArray['CREATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($sellCodeArray['CREATIONDATE'])) : null,
            isset($sellCodeArray['EDITIONUSER']) ? User::createFromArray($sellCodeArray['EDITIONUSER']) : null,
            isset($sellCodeArray['EDITIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($sellCodeArray['EDITIONDATE'])) : null
        );
    }
}
