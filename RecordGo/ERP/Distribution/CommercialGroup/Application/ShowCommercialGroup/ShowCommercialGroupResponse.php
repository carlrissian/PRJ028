<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\ShowCommercialGroup;

class ShowCommercialGroupResponse
{
    /**
     * @var array
     */
    private $commercialGroup;

    /**
     * @param $commercialGroup
     */
    public function __construct(array $commercialGroup)
    {
        $this->commercialGroup = $commercialGroup;
    }

    /**
     * @return array
     */
    public function getCommercialGroup(): array
    {
        return $this->commercialGroup;
    }
}
