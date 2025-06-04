<?php

declare(strict_types=1);

namespace Distribution\StopSale\Domain;

final class Branch
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $branchIATA;

    /**
     * Branch constructor
     *
     * @param integer $id
     * @param string|null $name
     * @param string|null $branchIATA
     */
    public function __construct(
        int $id,
        ?string $name = null,
        ?string $branchIATA = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->branchIATA = $branchIATA;
    }

    /**
     * Get the value of id
     *
     * @return  integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     *
     * @return  string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of branchIATA
     *
     * @return  string|null
     */
    public function getBranchIATA()
    {
        return $this->branchIATA;
    }


    /**
     * @param array|null $branchArray
     * @return self
     */
    final public static function createFromArray(?array $branchArray): self
    {
        return new self(
            intval($branchArray['ID']),
            $branchArray['BRANCHINTNAME'] ?? null,
            $branchArray['BRANCHIATA'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
        ];
    }
}
