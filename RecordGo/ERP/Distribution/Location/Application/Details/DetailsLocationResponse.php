<?php

declare(strict_types=1);

namespace Distribution\Location\Application\Details;

final class DetailsLocationResponse
{
    /**
     * @var array
     */
    private $location;

    /**
     * DetailsLocationResponse constructor.
     *
     * @param array $location
     */
    public function __construct(array $location)
    {
        $this->location = $location;
    }

    /**
     * @return array
     */
    public function getLocation(): array
    {
        return $this->location;
    }
}
