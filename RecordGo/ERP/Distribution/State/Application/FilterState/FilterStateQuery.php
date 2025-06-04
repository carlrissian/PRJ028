<?php

namespace Distribution\State\Application\FilterState;

class FilterStateQuery
{
    /**
     * @var int|null
     */
    private ?int $countryId;

    /**
     * FilterStateQuery constructor.
     *
     * @param int|null $countryId
     */
    public function __construct(?int $countryId = null)
    {
        $this->countryId = $countryId;
    }

    public function getCountryId(): ?int
    {
        return $this->countryId;
    }
}
