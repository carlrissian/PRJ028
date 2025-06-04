<?php
declare(strict_types=1);


namespace Distribution\Location\Application\GetLocation;


use Distribution\Location\Domain\LocationCriteria;
use Distribution\Location\Domain\LocationRepository;

class GetLocationHandler
{
    /**
     * @var LocationRepository
     */
    private LocationRepository $stationRepository;

    /**
     * GetLocationHandler constructor.
     * @param LocationRepository $stationRepository
     */
    public function __construct(LocationRepository $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    final public function handle(GetLocationQuery $query): GetLocationResponse
    {
        $response = $this->stationRepository->getBy(new LocationCriteria());
        // TODO fix
        return new GetLocationResponse($response->getCollection(), $response->getTotalRows());
    }
}