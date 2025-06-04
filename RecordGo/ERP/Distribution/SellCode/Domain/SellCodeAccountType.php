<?php

namespace Distribution\SellCode\Domain;

class SellCodeAccountType
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
     * SellCodeAccountType constructor.
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
     * @param array $sellCodeAccountTypeArray
     * @return self
     */
    public static function createFromArray(array $sellCodeAccountTypeArray): self
    {
        return new self(
            intval($sellCodeAccountTypeArray['ACCOUNTTYPEID']),
            isset($sellCodeAccountTypeArray['SELLCODEACCOUNTTYPE']) ? $sellCodeAccountTypeArray['SELLCODEACCOUNTTYPE']['NAME'] : null
        );
    }
}
