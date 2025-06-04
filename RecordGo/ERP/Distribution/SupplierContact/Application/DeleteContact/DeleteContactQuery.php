<?php
declare(strict_types=1);


namespace Distribution\SupplierContact\Application\DeleteContact;


class DeleteContactQuery
{
    /**
     * @var int
     */
    private int $id;

    /**
     * DeleteContactQuery constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     * get Id
     */
    public function getId(): int
    {
        return $this->id;
    }
}