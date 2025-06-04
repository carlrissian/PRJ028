<?php

namespace Distribution\RentalAgreement\Domain;

class Branch
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
     * @var string|null
     */
    private $branchKeyPU;

    /**
     * Branch constructor.
     * 
     * @param int $id
     * @param string|null $name
     * @param string|null $branchKeyPU
     */
    public function __construct(int $id, ?string $name = null, ?string $branchKeyPU = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->branchKeyPU = $branchKeyPU;
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getBranchKeyPU(): ?string
    {
        return $this->branchKeyPU;
    }


    /**
     * @param array $branchArray
     * @return self
     */
    public static function createFromArray(array $branchArray): self
    {
        return new self(
            intval($branchArray['ID']),
            $branchArray['BRANCHINTNAME'] ?? null,
            $branchArray['BRANCHKEYPU'] ?? null
        );
    }
}
