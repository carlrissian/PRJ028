<?php

namespace Distribution\RentalAgreement\Application\ListRentalAgreementByVehicle;

use Distribution\RentalAgreement\Domain\RentalAgreementRepository;

class ListRentalAgreementByVehicleQueryHandler
{
    /**
     * @var RentalAgreementRepository
     */
    private RentalAgreementRepository $rentalAgreementRepository;

    /**
     * ListRentalAgreementByVehicleQueryHandler constructor.
     *
     * @param RentalAgreementRepository $rentalAgreementRepository
     */
    public function __construct(RentalAgreementRepository $rentalAgreementRepository)
    {
        $this->rentalAgreementRepository = $rentalAgreementRepository;
    }

    /**
     * @param ListRentalAgreementByVehicleQuery $query
     * @return ListRentalAgreementByVehicleResponse
     */
    public function handle(ListRentalAgreementByVehicleQuery $query): ListRentalAgreementByVehicleResponse
    {
        $response = $this->rentalAgreementRepository->getByVehicle($query->getVehicleId());

        // TODO lógica

        return new ListRentalAgreementByVehicleResponse($response->getCollection()->toArray(), $response->getTotalRows());
    }
}
