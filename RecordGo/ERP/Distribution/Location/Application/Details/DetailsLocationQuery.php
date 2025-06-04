<?php

declare(strict_types=1);

namespace Distribution\Location\Application\Details;

final class DetailsLocationQuery
{
    /**
     * @var int
     */
    private $locationId;

    /**
     * DetailsLocationQuery constructor.
     *
     * @param int $locationId
     */
    public function __construct(int $locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * @return int
     */
    public function getLocationId(): int
    {
        return $this->locationId;
    }
}
