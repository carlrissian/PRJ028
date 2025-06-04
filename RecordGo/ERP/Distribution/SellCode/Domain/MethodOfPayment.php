<?php

namespace Distribution\SellCode\Domain;

class MethodOfPayment
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * MethodOfPayment constructor.
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
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array $methodOfPaymentArray
     * @return self
     */
    public static function createFromArray(array $methodOfPaymentArray): self
    {
        return new self(
            intval($methodOfPaymentArray['ID']),
            $methodOfPaymentArray['NAME'] ?? null
        );
    }
}
