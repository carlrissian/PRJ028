<?php

namespace Distribution\InsurancePolicies\Domain;

class PolicyType
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * PolicyType constructor.
     * 
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param array $policyTypeArray
     * @return self
     */
    public static function createFromArray(array $policyTypeArray): self
    {
        return new self(
            intval($policyTypeArray['ID']),
            $policyTypeArray['POLICYTYPE']
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "ID" => $this->getId(),
            "POLICYTYPE" => $this->getName()
        ];
    }
}
