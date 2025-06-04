<?php
declare(strict_types=1);


namespace Distribution\SupplierContact\Application\UpdateContact;


class UpdateContactCommand
{
    /**
     * @var int
     */
    private int $id;
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
    private string $mail;
    /**
     * @var string
     */
    private string $phone;
    /**
     * @var string
     */
    private string $comment;

    /**
     * @param int $id
     * @param string $supplierCode
     * @param string $department
     * @param string $name
     * @param string $mail
     * @param string $phone
     * @param string $comment
     */
    public function __construct(int $id, string $supplierCode, string $department, string $name, string $mail, string $phone, string $comment)
    {
        $this->id = $id;
        $this->supplierCode = $supplierCode;
        $this->department = $department;
        $this->name = $name;
        $this->mail = $mail;
        $this->phone = $phone;
        $this->comment = $comment;
    }

    /**
     * @return int
     */
    public function getId(): int
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
    public function getMail(): string
    {
        return $this->mail;
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

}