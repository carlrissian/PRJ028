<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\UpdateCommercialGroup;

class UpdateCommercialGroupResponse
{
    /**
     * @var bool
     */
    private $updated;

    /**
     * @var bool
     */
    private $nameExists;

    public function __construct(bool $updated, bool $nameExists)
    {
        $this->updated = $updated;
        $this->nameExists = $nameExists;
    }

    /**
     * Get the value of updated
     *
     * @return bool
     */
    public function isUpdated(): bool
    {
        return $this->updated;
    }

    /**
     * Get the value of nameExists
     *
     * @return bool
     */
    public function nameExists(): bool
    {
        return $this->nameExists;
    }
}
