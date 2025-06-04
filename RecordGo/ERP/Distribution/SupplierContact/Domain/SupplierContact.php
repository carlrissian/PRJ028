<?php

declare(strict_types=1);

namespace Distribution\SupplierContact\Domain;

use Shared\Utils\DataValidation;

class SupplierContact
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string
     */
    private string $supplierCode;

    /**
     * @var string
     */
    private string $department;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $phone;

    /**
     * @var string
     */
    private string $comment;

    /**
     * Contact constructor.
     * @param int|null $id
     * @param string $supplierCode
     * @param string $department
     * @param string $name
     * @param string $email
     * @param string $phone
     * @param string $comment
     */
    public function __construct(
        ?int $id,
        string $supplierCode,
        string $department,
        string $name,
        string $email,
        string $phone,
        string $comment
    ) {
        $this->id = $id;
        $this->supplierCode = $supplierCode;
        $this->department = $department;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->comment = $comment;
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
    public function getSupplierCode(): string
    {
        return $this->supplierCode;
    }

    /**
     * @return string
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }


    /**
     * @param array|null $supplierContactArray
     * @return SupplierContact
     */
    public static function createFromArray(?array $supplierContactArray): SupplierContact
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($supplierContactArray, 'ID')),
            $helper->arrayExistOrNull($supplierContactArray, 'PROVIDERID'),
            $helper->arrayExistOrNull($supplierContactArray, 'DEPARTMENT'),
            $helper->arrayExistOrNull($supplierContactArray, 'NAME'),
            $helper->arrayExistOrNull($supplierContactArray, 'EMAIL'),
            $helper->arrayExistOrNull($supplierContactArray, 'PHONE'),
            $helper->arrayExistOrNull($supplierContactArray, 'NOTES')
        );
    }

    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'PROVIDERID' => $this->getSupplierCode(),
            'DEPARTMENT' => $this->getDepartment(),
            'NAME' => $this->getName(),
            'EMAIL' => $this->getEmail(),
            'PHONE' => $this->getPhone(),
            'NOTES' => $this->getComment(),
        ];
    }
}
