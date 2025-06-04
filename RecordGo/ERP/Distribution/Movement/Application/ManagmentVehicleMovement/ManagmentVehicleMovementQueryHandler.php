<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\ManagmentVehicleMovement;

use Shared\Utils\Utils;
use Distribution\Movement\Domain\Movement;
use App\Constants\ConnectedVehicleConstants;
use Distribution\Brand\Domain\BrandCriteria;
use Distribution\Model\Domain\ModelCriteria;
use Distribution\Brand\Domain\BrandException;
use Distribution\Model\Domain\ModelException;
use Distribution\Brand\Domain\BrandRepository;
use Distribution\Model\Domain\ModelRepository;
use Distribution\CarGroup\Domain\CarGroupCriteria;
use Distribution\CarGroup\Domain\CarGroupException;
use Distribution\Movement\Domain\MovementException;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\Movement\Domain\MovementRepository;
use Distribution\SaleMethod\Domain\SaleMethodCriteria;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Distribution\SaleMethod\Domain\SaleMethodRepository;
use Distribution\VehicleType\Domain\VehicleTypeCriteria;
use Distribution\VehicleType\Domain\VehicleTypeRepository;
use Distribution\VehicleStatus\Domain\VehicleStatusCriteria;
use Distribution\VehicleStatus\Domain\VehicleStatusRepository;
use Distribution\SaleMethod\Domain\SaleMethodNotFoundException;
use Distribution\VehicleType\Domain\VehicleTypeNotFoundException;
use Distribution\VehicleStatus\Domain\VehicleStatusNotFoundException;

class ManagmentVehicleMovementQueryHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * @var VehicleTypeRepository
     */
    private VehicleTypeRepository $vehicleTypeRepository;

    /**
     * @var VehicleStatusRepository
     */
    private VehicleStatusRepository $vehicleStatusRepository;

    /**
     * @var BrandRepository
     */
    private BrandRepository $brandRepository;

    /**
     * @var ModelRepository
     */
    private ModelRepository $modelRepository;

    /**
     * @var CarGroupRepository
     */
    private CarGroupRepository $carGroupRepository;

    /**
     * @var SaleMethodRepository
     */
    private SaleMethodRepository $saleMethodRepository;

    /**
     * ManagmentVehicleMovementQueryHandler constructor.
     *
     * @param MovementRepository $movementRepository
     * @param VehicleTypeRepository $vehicleTypeRepository
     * @param VehicleStatusRepository $vehicleStatusRepository
     * @param BrandRepository $brandRepository
     * @param ModelRepository $modelRepository
     * @param CarGroupRepository $carGroupRepository
     * @param SaleMethodRepository $saleMethodRepository
     */
    public function __construct(
        MovementRepository $movementRepository,
        VehicleTypeRepository $vehicleTypeRepository,
        VehicleStatusRepository $vehicleStatusRepository,
        BrandRepository $brandRepository,
        ModelRepository $modelRepository,
        CarGroupRepository $carGroupRepository,
        SaleMethodRepository $saleMethodRepository
    ) {
        $this->movementRepository = $movementRepository;
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->vehicleStatusRepository = $vehicleStatusRepository;
        $this->brandRepository = $brandRepository;
        $this->modelRepository = $modelRepository;
        $this->carGroupRepository = $carGroupRepository;
        $this->saleMethodRepository = $saleMethodRepository;
    }

    /**
     * @throws MovementException
     * @throws VehicleTypeNotFoundException
     * @throws VehicleStatusNotFoundException
     * @throws BrandException
     * @throws ModelException
     * @throws CarGroupException
     * @throws SaleMethodNotFoundException
     */
    public function handle(ManagmentVehicleMovementQuery $query): ManagmentVehicleMovementResponse
    {
        [
            $vehicleFilter,
            $assignedLicensePlateUnits
        ] = null;

        /**
         * @var Movement $movement
         */
        $movement = $this->movementRepository->getById($query->getMovementId());
        if (empty($movement)) {
            throw new MovementException('Error getting movement');
        }

        $vehicleTypeCollection = $this->vehicleTypeRepository->getBy(new VehicleTypeCriteria())->getCollection();
        if (empty($vehicleTypeCollection)) {
            throw new VehicleTypeNotFoundException('Error getting vehicle type');
        }

        $vehicleStatusCollection = $this->vehicleStatusRepository->getBy(new VehicleStatusCriteria())->getCollection();
        if (empty($vehicleStatusCollection)) {
            throw new VehicleStatusNotFoundException('Error getting vehicle status');
        }

        $brandCollection = $this->brandRepository->getBy(new BrandCriteria())->getCollection();
        if (empty($brandCollection)) {
            throw new BrandException('Error getting brand');
        }

        $modelCollection = $this->modelRepository->getBy(new ModelCriteria())->getCollection();
        if (empty($modelCollection)) {
            throw new ModelException('Error getting model');
        }

        $carGroupCollection = $this->carGroupRepository->getBy(new CarGroupCriteria())->getCollection();
        if (empty($carGroupCollection)) {
            throw new CarGroupException('Error getting vehicle group');
        }

        $saleMethodCollection = $this->saleMethodRepository->getBy(new SaleMethodCriteria())->getCollection();
        if (empty($saleMethodCollection)) {
            throw new SaleMethodNotFoundException('Error getting resale code');
        }

        $vehicleTypeList = Utils::createSelect($vehicleTypeCollection);
        $vehicleStatusList = Utils::createSelect($vehicleStatusCollection);
        $brandList = Utils::createSelect($brandCollection);
        $modelList = Utils::createCustomSelectList($modelCollection, 'id', 'name', 'brand.id');
        $carGroupList = Utils::createSelect($carGroupCollection);
        $saleMethodList = Utils::createSelect($saleMethodCollection);
        $connectedVehicleList = [
            ['id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_YES, 'name' => 'Sí'],
            ['id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_NO, 'name' => 'No'],
        ];

        $selectList = [
            'vehicleTypeList' => $vehicleTypeList,
            'vehicleStatusList' => $vehicleStatusList,
            'brandList' => $brandList,
            'modelList' => $modelList,
            'carGroupList' => $carGroupList,
            'saleMethodList' => $saleMethodList,
            'connectedVehicleList' => $connectedVehicleList,
        ];

        // Obtenemos los filtros
        if (!empty($movement->getVehicleFilterCollection())) {
            foreach ($movement->getVehicleFilterCollection() as $object) {
                $vehicleFilter = [
                    'vehicleTypeIdIn' => $object->getVehicleTypeCollection() ?? null,
                    'brandIdIn' => $object->getBrandCollection() ?? null,
                    'modelIdIn' => $object->getModelCollection() ?? null,
                    'carGroupIdIn' => $object->getCarGroupCollection() ?? null,
                    'kilometersFrom' => $object->getKilometersFrom() ?? null,
                    'kilometersTo' => $object->getKilometersTo() ?? null,
                    'rentingEndDateFrom' => $object->getRentingEndDateFrom() ?? null,
                    'rentingEndDateTo' => $object->getRentingEndDateTo() ?? null,
                    'checkInDateFrom' => $object->getCheckInDateFrom() ?? null,
                    'saleMethodIdIn' => $object->getSaleMethodCollection() ?? null,
                    'vehicleStatusIdIn' => $object->getVehicleStatusCollection() ?? null,
                    'connectedVehicle' => $object->isConnectedVehicle() ?? null,
                ];
            }
        }

        if (in_array($movement->getMovementType()->getId(), [ConstantsJsonFile::getValue("TRANSPORTTYPE_CARRIER"), ConstantsJsonFile::getValue("TRANSPORTTYPE_OPERATION")])) {
            $assignedLicensePlateUnits = [
                'total' => $movement->getAssignedLicensePlateUnits()->getTotal(),
                'load' => $movement->getAssignedLicensePlateUnits()->getLoad(),
                'unload' => $movement->getAssignedLicensePlateUnits()->getUnload(),
            ];
        }

        $originLocationId = $movement->getOriginLocation() ? $movement->getOriginLocation()->getId() : ($movement->getOriginExternalLocation() ? $movement->getOriginExternalLocation()->getId() : null);

        $movement = [
            'id' => $movement->getId(),
            'movementTypeId' => $movement->getMovementType()->getId(),
            'movementStatusId' => $movement->getMovementStatus()->getId(),
            'originLocationId' => $originLocationId,
            'vehicleUnits' => $movement->getVehicleUnits() ?? 0,
            'businessUnitArticleId' => $movement->getBusinessUnitArticle() ? $movement->getBusinessUnitArticle()->getId() : null,
            'transportMethodId' => $movement->getTransportMethod() ? $movement->getTransportMethod()->getId() : null,
            'assignedLicensePlateUnits' => $assignedLicensePlateUnits,
            'vehicleFilter' => $vehicleFilter,
        ];


        return new ManagmentVehicleMovementResponse(
            $selectList,
            $movement
        );
    }
}
