<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\GetAutomaticCost;

use Distribution\Route\Domain\RouteRepository;
use Distribution\Location\Domain\LocationRepository;
use Distribution\Route\Domain\RouteGetByAutomaticCostRequest;

class GetAutomaticCostCommandHandler
{
    /**
     * @var RouteRepository
     */
    private RouteRepository $routeRepository;

    /**
     * @var LocationRepository
     */
    private LocationRepository $locationRepository;

    /**
     * GetAutomaticCostCommandHandler constructor.
     * 
     * @param RouteRepository $routeRepository
     * @param LocationRepository $locationRepository
     */
    public function __construct(RouteRepository $routeRepository, LocationRepository $locationRepository)
    {
        $this->routeRepository = $routeRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * @param GetAutomaticCostCommand $command
     * @return GetAutomaticCostResponse
     */
    public function handle(GetAutomaticCostCommand $command): GetAutomaticCostResponse
    {
        $response = $this->routeRepository->getByAutomaticCost(
            new RouteGetByAutomaticCostRequest(
                $command->getOriginBranchId(),
                $command->getDestinationBranchId(),
                $command->getProviderId(),
                $command->getTransportMethodId(),
                $command->getUnits(),
            )
        );

        return new GetAutomaticCostResponse($response->getAutomaticCost());
    }
}
