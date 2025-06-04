<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\StoreCommercialGroup;

class StoreCommercialGroupResponse
{
    /**
     * @var boolean
     */
    private bool $created;

    /**
     * @var boolean
     */
    private bool $nameExists;

    public function __construct(bool $created, bool $nameExists)
    {
        $this->created = $created;
        $this->nameExists = $nameExists;
    }

    /**
     * Get the value of created
     *
     * @return boolean
     */
    public function isCreated(): bool
    {
        return $this->created;
    }

    /**
     * Get the value of nameExists
     *
     * @return boolean
     */
    public function nameExists(): bool
    {
        return $this->nameExists;
    }
}
