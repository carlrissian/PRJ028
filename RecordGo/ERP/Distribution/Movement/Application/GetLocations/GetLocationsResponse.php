<?php
declare(strict_types=1);


namespace Distribution\Movement\Application\GetLocations;


class GetLocationsResponse
{
    /**
     * @var array
     */
    private array $locationsArray;

    /**
     * GetLocationsResponse constructor.
     * @param array $locationsArray
     */
    public function __construct(array $locationsArray)
    {
        $this->locationsArray = $locationsArray;
    }

    /**
     * @return array
     */
    public function getLocationsArray(): array
    {
        return $this->locationsArray;
    }

}