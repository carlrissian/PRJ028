<?php

declare(strict_types=1);

namespace Distribution\Route\Domain;

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
     * Branch constructor
     *
     * @param integer $id
     * @param string|null $name
     */
    public function __construct(
        int $id,
        ?string $name = null
    ) {
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
     * @return  string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array $branchArray
     * @return self
     */
    public static function createFromArray(array $branchArray): self
    {
        return new self(
            intval($branchArray['ID']),
            $branchArray['BRANCHINTNAME'] ?? null
        );
    }
}
