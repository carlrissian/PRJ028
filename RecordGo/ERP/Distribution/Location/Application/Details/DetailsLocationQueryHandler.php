<?php

declare(strict_types=1);

namespace Distribution\Location\Application\Details;

use Distribution\Location\Domain\LocationRepository;

final class DetailsLocationQueryHandler
{
    /**
     * @var LocationRepository
     */
    private LocationRepository $locationRepository;

    /**
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @param LocationDetailQuery $query
     * @return array
     */
    final public function handle(DetailsLocationQuery $query): DetailsLocationResponse
    {
        $response = $this->locationRepository->getById($query->getLocationId());
        return new DetailsLocationResponse([$response]);
    }
}
