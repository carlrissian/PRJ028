<?php

declare(strict_types=1);

namespace Distribution\Branch\Domain;

use JsonSerializable;

final class Branch implements JsonSerializable
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * @var integer|null
     */
    private ?int $branchGroupId;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $branchIATA;

    /**
     * @var Area|null
     */
    private ?Area $area;

    /**
     * Branch constructor
     *
     * @param integer $id
     * @param integer|null $branchGroupId
     * @param string|null $name
     * @param string|null $branchIATA
     * @param Area|null $area
     */
    public function __construct(
        int $id,
        ?int $branchGroupId = null,
        ?string $name = null,
        ?string $branchIATA = null,
        ?Area $area = null
    ) {
        $this->id = $id;
        $this->branchGroupId = $branchGroupId;
        $this->name = $name;
        $this->branchIATA = $branchIATA;
        $this->area = $area;
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
     * Get the value of branchGroupId
     *
     * @return  integer|null
     */
    public function getBranchGroupId()
    {
        return $this->branchGroupId;
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
     * Get the value of area
     *
     * @return  Area|null
     */
    public function getArea()
    {
        return $this->area;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }


    /**
     * @param array|null $branchArray
     * @return Branch
     */
    public static function createFromArray(?array $branchArray): Branch
    {
        return new self(
            intval($branchArray['ID']),
            isset($branchArray['GROUP']) ? intval($branchArray['GROUP']['ID']) : (isset($branchArray['BRANCHGROUPID']) ? intval($branchArray['BRANCHGROUPID']) : null),
            $branchArray['BRANCHINTNAME'] ?? null,
            $branchArray['BRANCHIATA'] ?? null,
            isset($branchArray['AREA']) ? Area::createFromArray($branchArray['AREA']) : null
        );
    }
}
