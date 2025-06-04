<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

/**
 * Class Branch
 * @package Distribution\Vehicle\Domain
 */
class Branch
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
     * @var integer|null
     */
    private ?int $branchGroupId;

    /**
     * Branch constructor.
     *
     * @param integer $id
     * @param string|null $name
     * @param string|null $branchIATA
     * @param integer|null $branchGroupId
     */
    public function __construct(
        int $id,
        ?string $name = null,
        ?string $branchIATA = null,
        ?int $branchGroupId = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->branchIATA = $branchIATA;
        $this->branchGroupId = $branchGroupId;
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
     * Get the value of branchIATA
     *
     * @return  string|null
     */
    public function getBranchIATA(): ?string
    {
        return $this->branchIATA;
    }

    /**
     * Get the value of branchGroupId
     *
     * @return integer|null
     */
    public function getBranchGroupId(): ?int
    {
        return $this->branchGroupId;
    }

    /**
     * Set the value of branchGroupId
     *
     * @param integer  $branchGroupId
     */
    public function setBranchGroupId(int $branchGroupId)
    {
        $this->branchGroupId = $branchGroupId;
    }


    /**
     * @param array|null $branchArray
     * @return self
     */
    public static function createFromArray(?array $branchArray): self
    {
        return new self(
            intval($branchArray['ID']),
            $branchArray['BRANCHINTNAME'] ?? null,
            $branchArray['BRANCHIATA'] ?? null,
            isset($branchArray['BRANCHGROUPID']) ? intval($branchArray['BRANCHGROUPID']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'BRANCHINTNAME' => $this->getName(),
            'BRANCHIATA' => $this->getBranchIATA(),
            'BRANCHGROUPID' => $this->getBranchGroupId() ?? null
        ];
    }
}
