<?php
declare(strict_types=1);

namespace Distribution\Movement\Application\GetDestinations;

class GetDestinationsResponse
{
    /**
     * @var array
     */
    private array $destinations;

    /**
     * GetDestinationsResponse constructor.
     * @param array $destinations
     */
    public function __construct(array $destinations)
    {
        $this->destinations = $destinations;
    }

    /**
     * @return array
     */
    public function getDestinations(): array
    {
        return $this->destinations;
    }


}
