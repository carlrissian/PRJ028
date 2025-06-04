<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\StoreCommercialGroup;

class StoreCommercialGroupCommand
{
    /**
     * @var string $name
     */
    private string $name;

    /**
     * @var array $acrissIds
     */
    private array $acrissIds;

    /**
     * @var boolean|null
     */
    private ?bool $active;

    /**
     * @param string $name
     * @param array $acrissIds
     */
    public function __construct(string $name, array $acrissIds, ?bool $active)
    {
        $this->name = $name;
        $this->acrissIds = $acrissIds;
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @return array
     */
    public function getAcrissIds(): array
    {
        return $this->acrissIds;
    }

    /**
     * Get the value of active
     *
     * @return boolean|null
     */
    public function isActive(): ?bool
    {
        return $this->active;
    }
}
