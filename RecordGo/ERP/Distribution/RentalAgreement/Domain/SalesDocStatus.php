<?php

namespace Distribution\RentalAgreement\Domain;

class SalesDocStatus
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * SalesDocStatus constructor.
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
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array $salesDocStatusArray
     * @return self
     */
    public static function createFromArray(array $salesDocStatusArray): self
    {
        return new self(
            intval($salesDocStatusArray['ID']),
            $salesDocStatusArray['STATUSNAME'] ?? null
        );
    }
}
