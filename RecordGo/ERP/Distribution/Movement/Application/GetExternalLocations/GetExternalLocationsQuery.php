<?php

declare(strict_types=1);


namespace Distribution\Movement\Application\GetExternalLocations;


class GetExternalLocationsQuery
{
    /**
     * @var int|null
     */
    private ?int $providerId;

    /**
     * GetExternalLocationsQuery constructor.
     * 
     * @param int|null $providerId
     */
    public function __construct(?int $providerId)
    {
        $this->providerId = $providerId;
    }

    /**
     * @return int|null
     */
    public function getProviderId(): ?int
    {
        return $this->providerId;
    }
}
