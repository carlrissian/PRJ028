<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\ShowStatusChangeDocType;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Movement\Domain\MovementCriteria;
use Distribution\Movement\Domain\MovementRepository;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Distribution\Maintenance\Domain\MaintenanceRepository;
use Distribution\RentalAgreement\Domain\RentalAgreementRepository;

class ShowStatusChangeDocTypeQueryHandler
{
    /**
     * @var RentalAgreementRepository
     */
    private RentalAgreementRepository $rentalAgreementRepository;
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;
    /**
     * @var MaintenanceRepository
     */
    private MaintenanceRepository $maintenanceRepository;

    /**
     * @param RentalAgreementRepository $rentalAgreementRepository
     * @param MovementRepository $movementRepository
     * @param MaintenanceRepository $maintenanceRepository
     */
    public function __construct(RentalAgreementRepository $rentalAgreementRepository, MovementRepository $movementRepository, MaintenanceRepository $maintenanceRepository)
    {
        $this->rentalAgreementRepository = $rentalAgreementRepository;
        $this->movementRepository = $movementRepository;
        $this->maintenanceRepository = $maintenanceRepository;
    }


    public function handle(ShowStatusChangeDocTypeQuery $query): ShowStatusChangeDocTypeResponse
    {
        $documentId = $query->getDocumentId();
        $vehicleId = $query->getVehicleId();
        $documentTypeId = $query->getDocumentTypeId();
        $licensePlate = $query->getLicensePlate();
        $actualLoadDate = $query->getActualLoadDate();
        $data = [];
        switch ($documentTypeId) {
            case intval(ConstantsJsonFile::getValue('CARSTATUS_ON_RENT')):
                $rentalAgreement = $this->rentalAgreementRepository->getById($documentId);

                $data = [
                    'contractId' => $rentalAgreement->getContractId(),
                    'contractSignatureDate' => $rentalAgreement->getContractSignatureDate()->__toString(),
                    'dropOffDate' => $rentalAgreement->getDropOffDate()->__toString(),
                    'bookedAcriss' => $rentalAgreement->getBookedAcriss(),
                    'bookedCarGroup' => $rentalAgreement->getBookedGroup(),
                    'acrissHired' => $rentalAgreement->getAcrissHired(),
                    'groupHired' => $rentalAgreement->getGroupHired(),
                    'pickUpBranch' => $rentalAgreement->getPickUpBranch(),
                    'dropOffBranch' => $rentalAgreement->getDropOffBranch(),
                    'startKilometers' => $rentalAgreement->getStartKilometers(),
                    'kmsPolicyName' => $rentalAgreement->getKmPolicyName(),
                    'kmsPolicyLimit' => $rentalAgreement->getKmsPolicyLimit(),
                    'salesLines' => $rentalAgreement->getSalesLineCollection()
                ];
                break;
            case intval(ConstantsJsonFile::getValue('CARSTATUS_ON_TRANSPORT')):
            case intval(ConstantsJsonFile::getValue('CARSTATUS_ON_TRANSPORT_WORKSHOP')):
            case intval(ConstantsJsonFile::getValue('CARSTATUS_ON_TRANSPORT_SALE')):
            case intval(ConstantsJsonFile::getValue('CARSTATUS_SOLD_ON_TRANSPORT')):

                $movementFilterCollection = new FilterCollection([]);
                $movementFilterCollection->add(new Filter('actualLoadDate', new FilterOperator(FilterOperator::EQUAL), strval($actualLoadDate)));
                $movementFilterCollection->add(new Filter('licensePlate', new FilterOperator(FilterOperator::EQUAL), strval($licensePlate)));

                $movementResponse = $this->movementRepository->getBy(new MovementCriteria($movementFilterCollection));

                $movement = $movementResponse->getCollection()[0];

                $originLocation = $movement->getOriginLocation() ?: $movement->getManualOriginLocation();
                $destinationLocation = $movement->getDestinationLocation() ?: $movement->getManualDestinationLocation();


                $data = [
                    'movementId' => $movement->getId(),
                    'expectedUnLoadDate' => $movement->getExpectedUnloadDate()->__toString(),
                    'pickUpBranch' => $movement->getOriginBranch(),
                    'originLocation' => $originLocation,
                    'dropOffBranch' => $movement->getDestinationBranch(),
                    'destinationLocation' => $destinationLocation
                ];

                break;
            case intval(ConstantsJsonFile::getValue('CARSTATUS_PENDING_REPAIR')):
            case intval(ConstantsJsonFile::getValue('CARSTATUS_SOLD_REPAIR')):
            case intval(ConstantsJsonFile::getValue('CARSTATUS_MAINTENANCE_WORKSHOP')):

                $maintenanceDocument = $this->maintenanceRepository->getById($documentId);

                $data = [
                    'vehicleMaintenaceEndDate' => $maintenanceDocument->getMaintenanceEndDate(),
                ];

                break;
            case intval(ConstantsJsonFile::getValue('CARSTATUS_WORKSHOP_SALE')):
            case intval(ConstantsJsonFile::getValue('CARSTATUS_SALE')):
            case intval(ConstantsJsonFile::getValue('CARSTATUS_PENDING_WS_SALE')):
            case intval(ConstantsJsonFile::getValue('CARSTATUS_SOLD')):
            case intval(ConstantsJsonFile::getValue('CARSTATUS_CRANE')):
                //$data = [];
                break;
        }

        $responseArray = ['id' => $documentId, 'documentData' => $data];
        return new ShowStatusChangeDocTypeResponse($responseArray);
    }
}
