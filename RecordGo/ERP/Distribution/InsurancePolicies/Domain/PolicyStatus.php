<?php

namespace Distribution\InsurancePolicies\Domain;

class PolicyStatus
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
     * PolicyStatus constructor.
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
     * @param array $policyStatusArray
     * @return self
     */
    public static function createFromArray(array $policyStatusArray): self
    {
        return new self(
            intval($policyStatusArray['ID']),
            $policyStatusArray['POLICYSTATUS']
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "ID" => $this->getId(),
            "POLICYSTATUS" => $this->getName()
        ];
    }
}
