<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\UpdateCommercialGroup;

class UpdateCommercialGroupCommand
{
    /**
     * @var array|null
     */
    private $commercialGroup;

    /**
     * constructor
     *
     * @param array|null $commercialGroup
     */
    public function __construct(?array $commercialGroup)
    {
        $this->commercialGroup = $commercialGroup;
    }

    /**
     * Get the value of commercialGroup
     *
     * @return array|null
     */
    public function getCommercialGroup(): ?array
    {
        return $this->commercialGroup;
    }
}
