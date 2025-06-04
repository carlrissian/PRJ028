<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\ListVehicleAnticipations;

use Distribution\Vehicle\Domain\VehicleRepository;
use Distribution\Vehicle\Domain\VehicleAnticipation;

class ListVehicleAnticipationsQueryHandler
{
    /**
     * @var VehicleRepository
     */
    private VehicleRepository $vehicleRepository;

    /**
     * ListVehicleAnticipations constructor.
     * 
     * @param VehicleRepository $vehicleRepository
     */
    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @param ListVehicleAnticipationsQuery $query
     * @return ListVehicleAnticipationsResponse
     */
    public function handle(ListVehicleAnticipationsQuery $query): ListVehicleAnticipationsResponse
    {
        [$vehicleAnticipationCollection, $totalRows] = $this->vehicleRepository->getVehicleAnticipationsByVehicleId($query->getVehicleId())->toArray();

        $vehicleAnticipationList = [];
        /**
         * @var VehicleAnticipation $vehicleAnticipation
         */
        foreach ($vehicleAnticipationCollection as $vehicleAnticipation) {

            $vehicleAnticipationList[] = [
                'movementId' => $vehicleAnticipation->getMovementId(),
                'originLocation' => ($vehicleAnticipation->getOriginLocation()) ? $vehicleAnticipation->getOriginLocation()->getName() : null,
                'destinationLocation' => ($vehicleAnticipation->getDestinationLocation()) ? $vehicleAnticipation->getDestinationLocation()->getName() : null,
                'expectedLoadDate' => ($vehicleAnticipation->getExpectedLoadDate()) ? $vehicleAnticipation->getExpectedLoadDate()->__toString() : null,
                'expectedUnloadDate' => ($vehicleAnticipation->getExpectedUnloadDate()) ? $vehicleAnticipation->getExpectedUnloadDate()->__toString() : null,
                'businessUnitName' => ($vehicleAnticipation->getBusinessUnit()) ? $vehicleAnticipation->getBusinessUnit()->getName() : null,
                'businessUnitArticleName' => ($vehicleAnticipation->getBusinessUnitArticle()) ? $vehicleAnticipation->getBusinessUnitArticle()->getName() : null,
            ];
        }

        $vehicleAnticipationResponse['total'] = $totalRows;
        $vehicleAnticipationResponse['rows'] = $vehicleAnticipationList;

        return new ListVehicleAnticipationsResponse($vehicleAnticipationResponse);
    }
}
