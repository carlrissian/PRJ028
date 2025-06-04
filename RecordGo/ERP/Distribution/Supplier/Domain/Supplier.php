<?php

declare(strict_types=1);

namespace Distribution\Supplier\Domain;

use Shared\Utils\DataValidation;
use Distribution\State\Domain\State;

class Supplier
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string|null
     */
    private ?string $code;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $vatNumber;

    /**
     * @var string|null
     */
    private ?string $city;

    /**
     * @var State|null
     */
    private ?State $state;

    /**
     * @var SupplierType|null
     */
    private ?SupplierType $supplierType;


    /**
     * Supplier constructor.
     * @param int|null $id
     * @param string|null $code
     * @param string|null $name
     * @param string|null $vatNumber
     * @param string|null $city
     * @param State|null $state
     * @param SupplierType|null $supplierType
     */
    public function __construct(
        ?int $id,
        ?string $code,
        ?string $name,
        ?string $vatNumber,
        ?string $city,
        ?State $state,
        ?SupplierType $supplierType
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->vatNumber = $vatNumber;
        $this->city = $city;
        $this->state = $state;
        $this->supplierType = $supplierType;
    }


    /**
     * Get the value of id
     *
     * @return int|null
     */
    final public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int|null  $id
     */
    final public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of code
     *
     * @return string|null
     */
    final public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @param string|null  $code
     */
    final public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Get the value of name
     *
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the value of vatNumber
     *
     * @return string|null
     */
    final public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    /**
     * Get the value of city
     *
     * @return string|null
     */
    final public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Get the value of state
     *
     * @return State|null
     */
    final public function getState(): ?State
    {
        return $this->state;
    }

    /**
     * Get the value of supplierType
     *
     * @return SupplierType|null
     */
    final public function getSupplierType(): ?SupplierType
    {
        return $this->supplierType;
    }


    /**
     * @param array|null $supplierArray
     * @return Supplier
     */
    public static function createFromArray(?array $supplierArray): Supplier
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($supplierArray, 'ID')),
            $helper->intOrNull($helper->arrayExistOrNull($supplierArray, 'PROVIDERSAPID')),
            $helper->arrayExistOrNull($supplierArray, 'NAMESOCIAL'),
            $helper->arrayExistOrNull($supplierArray, 'VATNUM'),
            $helper->arrayExistOrNull($supplierArray, 'CITY'),
            (isset($supplierArray['PROVINCE'])) ? State::createFromArray($supplierArray['PROVINCE']) : null,
            (isset($supplierArray['SUPPLIERTYPE'])) ? SupplierType::createFromArray($supplierArray['SUPPLIERTYPE']) : null
        );
    }

    final public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'PROVIDERSAPID' => $this->getCode(),
            'NAMESOCIAL' => $this->getName(),
            'VATNUM' => $this->getVatNumber(),
            'CITY' => $this->getCity(),
            'PROVINCE' => ($this->getState() !== null) ? $this->getState()->toArray() : null,
            'SUPPLIERTYPE' => ($this->getSupplierType() !== null) ? $this->getSupplierType()->toArray() : null,
        ];
    }
}
