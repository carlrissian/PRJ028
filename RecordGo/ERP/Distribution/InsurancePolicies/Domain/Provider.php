<?php

namespace Distribution\InsurancePolicies\Domain;

class Provider
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
     * Provider constructor.
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
     * @param array $providerArray
     * @return self
     */
    public static function createFromArray(array $providerArray): self
    {
        return new self(
            intval($providerArray['ID']),
            $providerArray['NAMESOCIAL']
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "ID" => $this->getId(),
            "NAMESOCIAL" => $this->getName()
        ];
    }
}
