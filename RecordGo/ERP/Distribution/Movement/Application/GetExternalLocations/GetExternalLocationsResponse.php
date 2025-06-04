<?php
declare(strict_types=1);


namespace Distribution\Movement\Application\GetExternalLocations;


class GetExternalLocationsResponse
{
    /**
     * @var array
     */
    private array $externalLocationsArray;

    /**
     * GetExternalLocationsResponse constructor.
     * @param array $externalLocationsArray
     */
    public function __construct(array $externalLocationsArray)
    {
        $this->externalLocationsArray = $externalLocationsArray;
    }

    /**
     * @return array
     */
    public function getExternalLocationsArray(): array
    {
        return $this->externalLocationsArray;
    }

}