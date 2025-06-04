<?php

namespace Distribution\Movement\Domain;


class Location
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var LocationType|null
     */
    private ?LocationType $locationType;

    /**
     * @var Branch|null
     */
    private ?Branch $branch;
    /**
     * @var Supplier|null
     */
    private ?Supplier $supplier;

    /**
     * @param int $id
     * @param string|null $name
     * @param LocationType|null $locationType
     * @param Branch|null $branch
     * @param Supplier|null $supplier
     */
    public function __construct(
        int $id,
        ?string $name = null,
        ?LocationType $locationType = null,
        ?Branch $branch = null,
        ?Supplier $supplier = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->locationType = $locationType;
        $this->branch = $branch;
        $this->supplier = $supplier;
    }

    /**
     * @return int
     */
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return LocationType|null
     */
    final public function getLocationType(): ?LocationType
    {
        return $this->locationType;
    }

    /**
     * @return Branch|null
     */
    final public function getBranch(): ?Branch
    {
        return $this->branch;
    }

    /**
     * @return Supplier|null
     */
    final public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    /**
     * @param array|null $locationArray
     * @return self|null
     */
    public static function createFromArray(?array $locationArray): ?self
    {
        return (is_array($locationArray)) ? new self(
            intval($locationArray['ID']),
            $locationArray['LOCATIONNAME'],
            LocationType::createFromArray($locationArray['LOCATIONTYPE']),
            Branch::createFromArray($locationArray['BRANCH']),
            Supplier::createFromArray($locationArray['PROVIDER'])
        ) : null;
    }
}
