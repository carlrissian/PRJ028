<?php
declare(strict_types=1);


namespace Distribution\SupplierContact\Application\StoreContact;


class StoreContactCommand
{
    /**
     * @var string
     */
    private string $code;
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
     * @param string $code
     * @param string $department
     * @param string $name
     * @param string $mail
     * @param string $phone
     * @param string $comment
     */
    public function __construct(string $code, string $department, string $name, string $mail, string $phone, string $comment)
    {
        $this->code = $code;
        $this->department = $department;
        $this->name = $name;
        $this->mail = $mail;
        $this->phone = $phone;
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
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