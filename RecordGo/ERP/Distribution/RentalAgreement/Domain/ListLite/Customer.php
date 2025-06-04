<?php

namespace Distribution\RentalAgreement\Domain\ListLite;

final class Customer
{
    /**
     * @var integer
     */
    private int $id;
    /**
     * @var string
     */
    private string $name;

    /**
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return integer
     */
    public function getId(): int
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
     * @param array $customerArray
     * @return self
     */
    public static function createFromArray(array $customerArray): self
    {
        return new self(
            $customerArray['ID'],
            $customerArray['NAMESOCIAL'] ?? null,
        );
    }
}
