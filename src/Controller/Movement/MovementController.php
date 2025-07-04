<?php

declare(strict_types=1);

namespace App\Controller\Movement;

use Exception;
use App\Helpers;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Controller\Controller;
use Distribution\Movement\Domain\Department;
use Doctrine\DBAL\Exception\DriverException;
use Distribution\Brand\Domain\BrandException;
use Distribution\Model\Domain\ModelException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Distribution\Branch\Domain\BranchException;
use Distribution\Country\Domain\CountryException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\CarGroup\Domain\CarGroupException;
use Distribution\Location\Domain\LocationException;
use Distribution\Movement\Domain\MovementException;
use Distribution\Supplier\Domain\SupplierException;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Distribution\BusinessUnit\Domain\BusinessUnitException;
use Distribution\LocationType\Domain\LocationTypeException;
use Distribution\MovementStatus\Domain\MovementStatusException;
use Distribution\TransportMethod\Domain\TransportMethodException;
use Distribution\VehicleType\Domain\VehicleTypeNotFoundException;
use Distribution\Movement\Application\ListVehicle\ListVehicleQuery;
use Distribution\MovementCategory\Domain\MovementCategoryException;
use Distribution\Movement\Application\EditMovement\EditMovementQuery;
use Distribution\Movement\Application\GetLocations\GetLocationsQuery;
use Distribution\Movement\Application\ShowMovement\ShowMovementQuery;
use Distribution\VehicleStatus\Domain\VehicleStatusNotFoundException;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleException;
use Distribution\Movement\Application\CloseMovement\CloseMovementCommand;
use Distribution\Movement\Application\CreateMovement\CreateMovementQuery;
use Distribution\Movement\Application\FilterMovement\FilterMovementQuery;
use Distribution\Movement\Application\StoreMovement\StoreMovementCommand;
use Distribution\Movement\Application\ListVehicle\ListVehicleQueryHandler;
use Distribution\Movement\Application\CancelMovement\CancelMovementCommand;
use Distribution\Movement\Application\GetDestinations\GetDestinationsQuery;
use Distribution\Movement\Application\UpdateMovement\UpdateMovementCommand;
use Distribution\Movement\Domain\AssignVehicle\AssignVehicleExcelException;
use Distribution\Movement\Application\EditMovement\EditMovementQueryHandler;
use Distribution\Movement\Application\GetLocations\GetLocationsQueryHandler;
use Distribution\Movement\Application\ShowMovement\ShowMovementQueryHandler;
use Distribution\Movement\Application\GetAutomaticCost\GetAutomaticCostCommand;
use Distribution\Movement\Application\ValidateMovement\ValidateMovementCommand;
use Distribution\Movement\Application\CloseMovement\CloseMovementCommandHandler;
use Distribution\Movement\Application\CreateMovement\CreateMovementQueryHandler;
use Distribution\Movement\Application\FilterMovement\FilterMovementQueryHandler;
use Distribution\Movement\Application\StoreMovement\StoreMovementCommandHandler;
use Distribution\Movement\Application\AssignVehicleMovement\AssignVehicleCommand;
use Distribution\Movement\Application\UpdateDateVehicle\UpdateDateVehicleCommand;
use Distribution\Movement\Application\CancelMovement\CancelMovementCommandHandler;
use Distribution\Movement\Application\GetByIdMovement\GetByIdMovementQueryHandler;
use Distribution\Movement\Application\GetDestinations\GetDestinationsQueryHandler;
use Distribution\Movement\Application\UpdateMovement\UpdateMovementCommandHandler;
use Distribution\Movement\Application\GetByIdPdfMovement\GetByIdPdfMovementCommand;
use Distribution\Movement\Application\GetExternalLocations\GetExternalLocationsQuery;
use Distribution\Movement\Application\GetAutomaticCost\GetAutomaticCostCommandHandler;
use Distribution\Movement\Application\ValidateMovement\ValidateMovementCommandHandler;
use Distribution\Movement\Application\AssignVehicleMovement\AssignVehicleCommandHandler;
use Distribution\Movement\Application\UpdateDateVehicle\UpdateDateVehicleCommandHandler;
use Distribution\Movement\Application\DeleteVehicleMovement\DeleteVehicleMovementCommand;
use Distribution\Movement\Application\GetByIdPdfMovement\GetByIdPdfMovementCommandHandler;
use Distribution\Movement\Application\GetExternalLocations\GetExternalLocationsQueryHandler;
use Distribution\Movement\Application\ManagmentVehicleMovement\ManagmentVehicleMovementQuery;
use Distribution\Movement\Application\DeleteVehicleMovement\DeleteVehicleMovementCommandHandler;
use Distribution\Movement\Application\StoreDeliveryNotesMovement\StoreDeliveryNotesMovementCommand;
use Distribution\Movement\Application\ManagmentVehicleMovement\ManagmentVehicleMovementQueryHandler;
use Distribution\Movement\Application\ProcessFileAssignVehicle\ProcessFileAssignVehicleMovementCommand;
use Distribution\Movement\Application\StoreDeliveryNotesMovement\StoreDeliveryNotesMovementCommandHandler;
use Distribution\Movement\Application\ProcessFileAssignVehicle\ProcessFileAssignVehicleMovementCommandHandler;
use Distribution\Movement\Application\DownloadExcelTemplateAssignVehicles\DownloadExcelTemplateAssignVehiclesMovementCommandHandler;

class MovementController extends Controller
{
    // FIXME eliminar cuando se refactorice getDestinations
    /**
     * @var string
     */
    public static string $FLASH_OK = 'success';

    // FIXME eliminar cuando se refactorice getDestinations
    /**
     * @var string
     */
    public static string $FLASH_WARNING = 'warning';

    /**
     * @param string $movementType
     * @param Request $request
     * @return Response
     *
     * @throws SupplierException
     * @throws BusinessUnitArticleException
     * @throws VehicleStatusNotFoundException
     * @throws ModelException
     * @throws VehicleTypeNotFoundException
     * @throws LocationException
     * @throws ResaleCodeNotFoundException
     * @throws LocationTypeException
     * @throws MovementStatusException
     * @throws CountryException
     * @throws BusinessUnitException
     * @throws CarGroupException
     * @throws MovementCategoryException
     * @throws BrandException
     * @throws BranchException
     */
    public function list(string $movementType, Request $request): Response
    {
        $movementTypeId = $request->get('movementTypeId');

        return $this->render('pages/movement/list.html.twig', [
            'movementTypeId' => $movementTypeId,
            'movementTypeName' => $movementType,
            'loginUser' => $this->json($_SESSION["UserInfo"])->getContent(),
        ]);
    }

    /**
     * @param Request $request
     * @param FilterMovementQueryHandler $handler
     * @return Response
     *
     * @throws MovementException
     */
    public function filter(Request $request, FilterMovementQueryHandler $handler): Response
    {
        $sort = $request->get('sort') !== 'undefined' ? $request->get('sort', 'CREATIONDATE') : 'CREATIONDATE';
        $order = strtoupper($sort) == 'CREATIONDATE' ? 'desc' : $request->get('order');

        $statusIn = $request->get('movementStatusId') ?
            (is_numeric($request->get('movementStatusId')) ?
                [intval($request->get('movementStatusId'))]
                : json_decode($request->get('movementStatusId', '[]'))
            ) : null;

        $idIn = $request->get('orderMovement') ?
            (is_numeric($request->get('orderMovement')) ?
                [intval($request->get('orderMovement'))] :
                array_map('intval', explode(',', $request->get('orderMovement')))
            ) : null;

        $orderNumberIn = $request->get('orderNumber') ?
            (strpos($request->get('orderNumber'), ',') !== false ?
                explode(',', $request->get('orderNumber')) :
                [$request->get('orderNumber')]
            ) : null;

        $originBranch = json_decode($request->get('originBranchId', '[]'));
        $destinationBranch = json_decode($request->get('destinationBranchId', '[]'));

        $query = new FilterMovementQuery(
            intval($request->get('limit', 20)),
            intval($request->get('offset', 0)),
            $order,
            $sort,
            intval($request->get('movementTypeId')),
            json_decode($request->get('movementCategory', '[]')),
            $statusIn,
            $idIn,
            $orderNumberIn,
            !is_null($request->get('isExtTransport')) ? filter_var($request->get('isExtTransport'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null,
            $request->get('licensePlate') !== null ? strtoupper($request->get('licensePlate')) : null,
            $request->get('vin'),
            json_decode($request->get('brandId', '[]')),
            json_decode($request->get('modelId', '[]')),
            json_decode($request->get('supplierCode', '[]')),
            json_decode($request->get('originLocationId', '[]')),
            json_decode($request->get('destinationLocationId', '[]')),
            $originBranch,
            $destinationBranch,
            json_decode($request->get('businessUnitId', '[]')),
            json_decode($request->get('businessUnitArticleId', '[]')),
            $request->get('expectedLoadDate'),
            $request->get('actualLoadDate'),
            $request->get('expectedUnloadDate'),
            $request->get('actualUnloadDate'),
            $request->get('checkOutDateFrom'),
            $request->get('checkOutDateTo'),
            $request->get('expectedLoadDateFrom'),
            $request->get('expectedLoadDateTo'),
            $request->get('expectedUnloadDateFrom'),
            $request->get('expectedUnloadDateTo'),
            $request->get('actualLoadDateFrom'),
            $request->get('actualLoadDateTo'),
            $request->get('actualUnloadDateFrom'),
            $request->get('actualUnloadDateTo'),
            $request->get('creationUserName'),
            $request->get('creationDate'),
        );

        $response = $handler->handle($query);

        return $this->json($response->getMovementResponse());
    }

    /**
     * @param $movementType
     * @param Request $request
     * @param CreateMovementQueryHandler $handler
     * @return Response
     *
     *  @throws MovementCategoryException
     *  @throws TransportMethodException
     *  @throws SupplierException
     *  @throws DepartmentException
     *  @throws BusinessUnitException
     *  @throws BusinessUnitArticleException
     *  @throws LocationTypeException
     *  @throws BranchException
     *  @throws CountryException
     *  @throws VehicleTypeNotFoundException
     *  @throws VehicleStatusNotFoundException
     *  @throws BrandException
     *  @throws ModelException
     *  @throws CarGroupException
     *  @throws ResaleCodeNotFoundException
     */
    public function create($movementType, Request $request, CreateMovementQueryHandler $handler): Response
    {
        $movementTypeId = intval($request->get('movementTypeId'));

        $response = $handler->handle(new CreateMovementQuery($movementTypeId));

        return $this->render('pages/movement/create.html.twig', [
            'movementTypeId' => $movementTypeId,
            'movementTypeName' => $movementType,
            'selectList' => $this->json($response->getSelectList())->getContent(),
        ]);
    }

    /**
     * @param Request $request
     * @param StoreMovementCommandHandler $handler
     * @return JsonResponse
     */
    public function store(Request $request, StoreMovementCommandHandler $handler): JsonResponse
    {
        $command = new StoreMovementCommand(
            is_numeric($request->get('movementTypeId')) ? intval($request->get('movementTypeId')) : null,
            is_numeric($request->get('movementCategoryId')) ? intval($request->get('movementCategoryId')) : null,
            filter_var($request->get('extTransport'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            is_numeric($request->get('vehicleId')) ? intval($request->get('vehicleId')) : null,
            $request->get('expectedLoadDate') != 'null' ? $request->get('expectedLoadDate') : null,
            $request->get('actualLoadDate') != 'null' ? $request->get('actualLoadDate') : null,
            $request->get('expectedUnloadDate') != 'null' ? $request->get('expectedUnloadDate') : null,
            $request->get('actualUnloadDate') != 'null' ? $request->get('actualUnloadDate') : null,
            $request->get('departmentId') ? intval($request->get('departmentId')) : Department::DISTRIBUTION,
            is_numeric($request->get('providerId')) ? intval($request->get('providerId')) : null,
            is_numeric($request->get('driverId')) ? intval($request->get('driverId')) : null,
            $request->get('businessUnitId') != 'null' ? $request->get('businessUnitId') : null,
            $request->get('businessUnitArticleId') != 'null' ? $request->get('businessUnitArticleId') : null,
            is_numeric($request->get('transportMethodId')) ? intval($request->get('transportMethodId')) : null,
            is_numeric($request->get('vehicleUnits')) ? intval($request->get('vehicleUnits')) : null,
            is_numeric($request->get('manualCost')) ? floatval($request->get('manualCost')) : null,
            is_numeric($request->get('automaticCost')) ? floatval($request->get('automaticCost')) : null,
            $request->get('notes') != 'null' ? $request->get('notes') : null,

            is_numeric($request->get('originLocationId')) ? intval($request->get('originLocationId')) : null,
            $request->get('originLocationName') != 'null' ? $request->get('originLocationName') : null,   // TODO REVISAR ESTO SI ES NECESARIO
            /**
             * CARRIER -> Origin external location
             */
            is_numeric($request->get('originExternalProviderId')) ? intval($request->get('originExternalProviderId')) : null,
            is_numeric($request->get('originExternalLocationId')) ? intval($request->get('originExternalLocationId')) : null,
            /**
             * DRIVER -> Origin manual  location
             */
            is_numeric($request->get('manualOriginLocationCountryId')) ? intval($request->get('manualOriginLocationCountryId')) : null,
            is_numeric($request->get('manualOriginLocationProvinceId')) ? intval($request->get('manualOriginLocationProvinceId')) : null,
            $request->get('manualOriginLocationNotes') != 'null' ? $request->get('manualOriginLocationNotes') : null,

            is_numeric($request->get('destinationLocationId')) ? intval($request->get('destinationLocationId')) : null,
            /**
             * DRIVER, CARRIER -> Destination external location
             */
            is_numeric($request->get('destinationExternalProviderId')) ? intval($request->get('destinationExternalProviderId')) : null,
            is_numeric($request->get('destinationExternalLocationId')) ? intval($request->get('destinationExternalLocationId')) : null,
            /**
             * DRIVER -> Destination manual location
             */
            is_numeric($request->get('manualDestinationLocationCountryId')) ? intval($request->get('manualDestinationLocationCountryId')) : null,
            is_numeric($request->get('manualDestinationLocationProvinceId')) ? intval($request->get('manualDestinationLocationProvinceId')) : null,
            $request->get('manualDestinationLocationNotes') != 'null' ? $request->get('manualDestinationLocationNotes') : null,

            /**
             * Filters Carrier
             */
            $request->get('vehicleTypeIdIn'),
            $request->get('brandIdIn'),
            $request->get('modelIdIn'),
            $request->get('carGroupIdIn'),
            is_numeric($request->get('kilometersFrom')) ? intval($request->get('kilometersFrom')) : null,
            is_numeric($request->get('kilometersTo')) ? intval($request->get('kilometersTo')) : null,
            $request->get('rentingEndDateFrom') != 'null' ? $request->get('rentingEndDateFrom') : null,
            $request->get('rentingEndDateTo') != 'null' ? $request->get('rentingEndDateTo') : null,
            $request->get('checkInDateFrom') != 'null' ? $request->get('checkInDateFrom') : null,
            $request->get('saleMethodIdIn'),
            $request->get('vehicleStatusIdIn'),
            filter_var($request->get('connectedVehicle'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
        );

        $response = $handler->handle($command);

        return $this->json(
            [
                'id' => $response->getId(),
                'message' => $response->getMessage(),
            ],
            !$response->wasSuccess() ? $response->getCode() : 200
        );
    }

    /**
     * @param integer $id
     * @param ShowMovementQueryHandler $handler
     * @return Response
     */
    public function show(int $id, ShowMovementQueryHandler $handler): Response
    {
        $response = $handler->handle(new ShowMovementQuery($id));

        return $this->render('pages/movement/details.html.twig', [
            'movementTypeId' => $response->getMovementTypeId(),
            'movement' => $this->json($response->getMovement())->getContent(),
        ]);
    }

    /**
     * @param integer $id
     * @param EditMovementQueryHandler $handler
     * @return Response
     *
     *  @throws MovementCategoryException
     *  @throws TransportMethodException
     *  @throws SupplierException
     *  @throws DepartmentException
     *  @throws BusinessUnitException
     *  @throws BusinessUnitArticleException
     *  @throws LocationTypeException
     *  @throws BranchException
     *  @throws CountryException
     *  @throws VehicleTypeNotFoundException
     *  @throws VehicleStatusNotFoundException
     *  @throws BrandException
     *  @throws ModelException
     *  @throws CarGroupException
     *  @throws ResaleCodeNotFoundException
     */
    public function edit(int $id, EditMovementQueryHandler $handler): Response
    {
        $response = $handler->handle(new EditMovementQuery($id));

        return $this->render('pages/movement/edit.html.twig', [
            'id' => $id,
            'movementTypeId' => $response->getMovementTypeId(),
            'movement' => $this->json($response->getMovement())->getContent(),
            'selectList' => $this->json($response->getSelectList())->getContent(),
        ]);
    }

    /**
     * @throws BusinessUnitException
     * @throws LocationException
     * @throws DriverException
     * @throws BusinessUnitArticleException
     */
    public function update(int $id, Request $request, UpdateMovementCommandHandler $handler): JsonResponse
    {
        $command = new UpdateMovementCommand(
            $id,
            is_numeric($request->get('movementTypeId')) ? intval($request->get('movementTypeId')) : null,
            is_numeric($request->get('movementCategoryId')) ? intval($request->get('movementCategoryId')) : null,
            filter_var($request->get('extTransport'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            is_numeric($request->get('vehicleId')) ? intval($request->get('vehicleId')) : null,
            $request->get('expectedLoadDate') != 'null' ? $request->get('expectedLoadDate') : null,
            $request->get('actualLoadDate') != 'null' ? $request->get('actualLoadDate') : null,
            $request->get('expectedUnloadDate') != 'null' ? $request->get('expectedUnloadDate') : null,
            $request->get('actualUnloadDate') != 'null' ? $request->get('actualUnloadDate') : null,
            $request->get('departmentId') ? intval($request->get('departmentId')) : Department::DISTRIBUTION,
            is_numeric($request->get('providerId')) ? intval($request->get('providerId')) : null,
            is_numeric($request->get('driverId')) ? intval($request->get('driverId')) : null,
            $request->get('businessUnitId') != 'null' ? $request->get('businessUnitId') : null,
            $request->get('businessUnitArticleId') != 'null' ? $request->get('businessUnitArticleId') : null,
            is_numeric($request->get('transportMethodId')) ? intval($request->get('transportMethodId')) : null,
            is_numeric($request->get('vehicleUnits')) ? intval($request->get('vehicleUnits')) : null,
            is_numeric($request->get('manualCost')) ? floatval($request->get('manualCost')) : null,
            is_numeric($request->get('automaticCost')) ? floatval($request->get('automaticCost')) : null,
            $request->get('notes') != 'null' ? $request->get('notes') : null,

            is_numeric($request->get('originLocationId')) ? intval($request->get('originLocationId')) : null,
            $request->get('originLocationName') != 'null' ? $request->get('originLocationName') : null,   // TODO REVISAR ESTO SI ES NECESARIO
            /**
             * CARRIER -> Origin external location
             */
            is_numeric($request->get('originExternalProviderId')) ? intval($request->get('originExternalProviderId')) : null,
            is_numeric($request->get('originExternalLocationId')) ? intval($request->get('originExternalLocationId')) : null,
            /**
             * DRIVER -> Origin manual  location
             */
            is_numeric($request->get('manualOriginLocationCountryId')) ? intval($request->get('manualOriginLocationCountryId')) : null,
            is_numeric($request->get('manualOriginLocationProvinceId')) ? intval($request->get('manualOriginLocationProvinceId')) : null,
            $request->get('manualOriginLocationNotes') != 'null' ? $request->get('manualOriginLocationNotes') : null,

            is_numeric($request->get('destinationLocationId')) ? intval($request->get('destinationLocationId')) : null,
            /**
             * DRIVER, CARRIER -> Destination external location
             */
            is_numeric($request->get('destinationExternalProviderId')) ? intval($request->get('destinationExternalProviderId')) : null,
            is_numeric($request->get('destinationExternalLocationId')) ? intval($request->get('destinationExternalLocationId')) : null,
            /**
             * DRIVER -> Destination manual location
             */
            is_numeric($request->get('manualDestinationLocationCountryId')) ? intval($request->get('manualDestinationLocationCountryId')) : null,
            is_numeric($request->get('manualDestinationLocationProvinceId')) ? intval($request->get('manualDestinationLocationProvinceId')) : null,
            $request->get('manualDestinationLocationNotes') != 'null' ? $request->get('manualDestinationLocationNotes') : null,

            /**
             * Filters Carrier
             */
            $request->get('vehicleTypeIdIn'),
            $request->get('brandIdIn'),
            $request->get('modelIdIn'),
            $request->get('carGroupIdIn'),
            is_numeric($request->get('kilometersFrom')) ? intval($request->get('kilometersFrom')) : null,
            is_numeric($request->get('kilometersTo')) ? intval($request->get('kilometersTo')) : null,
            $request->get('rentingEndDateFrom') != 'null' ? $request->get('rentingEndDateFrom') : null,
            $request->get('rentingEndDateTo') != 'null' ? $request->get('rentingEndDateTo') : null,
            $request->get('checkInDateFrom') != 'null' ? $request->get('checkInDateFrom') : null,
            $request->get('saleMethodIdIn'),
            $request->get('vehicleStatusIdIn'),
            filter_var($request->get('connectedVehicle'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
        );

        $response = $handler->handle($command);

        return $this->json(
            [
                'id' => $response->getId(),
                'message' => $response->getMessage(),
            ],
            !$response->wasSuccess() ? $response->getCode() : 200
        );
    }

    /**
     * @param Request $request
     * @param ValidateMovementCommandHandler $handler
     * @return Response
     */
    public function validate(Request $request, ValidateMovementCommandHandler $handler): Response
    {
        $command = new ValidateMovementCommand(
            intval($request->get('movementId')),
            $request->get('vehicleLinesId'),
            $request->get('actualLoadDate'),
            $request->get('actualUnloadDate'),
            $request->get('action')
        );

        $response = $handler->handle($command);

        return $this->json(['validated' => $response->isValidated(), 'message' => $response->getMessage()]);
    }

    /**
     * @param Request $request
     * @param CloseMovementCommandHandler $handler
     * @return Response
     */
    public function close(Request $request, CloseMovementCommandHandler $handler): JsonResponse
    {
        $command = new CloseMovementCommand(
            intval($request->get('id')),
            intval($request->get('actualKms')),
            $request->get('tankActualOctaves') ? intval($request->get('tankActualOctaves')) : null,
            $request->get('batteryActual') ? floatval($request->get('batteryActual')) : null,
            $request->get('manualCost') ? floatval($request->get('manualCost')) : null,
            $request->get('actualUnloadDate'),
            $request->get('closingNotes')
        );

        $response = $handler->handle($command);

        return $this->json(['closed' => $response->isClosed(), "message" => $response->getMessage()], $response->getCode());
    }

    /**
     * @param Request $request
     * @param CancelMovementCommandHandler $handler
     * @return Response
     */
    public function cancel(Request $request, CancelMovementCommandHandler $handler): Response
    {
        $command = new CancelMovementCommand(
            intval($request->get('movementId')),
            $request->get('cancelationNotes')
        );

        $response = $handler->handle($command);

        return $this->json(['cancelled' => $response->isCancelled(), "message" => $response->getMessage()], $response->getCode());
    }

    /**
     *  @throws MovementException
     *  @throws VehicleTypeNotFoundException
     *  @throws VehicleStatusNotFoundException
     *  @throws BrandException>
     *  @throws ModelException
     *  @throws CarGroupException
     *  @throws ResaleCodeNotFoundException
     */
    public function listAssignVehicle(int $id, ManagmentVehicleMovementQueryHandler $handler): Response
    {
        $response = $handler->handle(new ManagmentVehicleMovementQuery($id));

        return $this->render('pages/movement/assignVehicle.html.twig', [
            'selectList' => $this->json($response->getSelectList())->getContent(),
            'movement' => $this->json($response->getMovement())->getContent(),
        ]);
    }

    /**
     * @param integer $id
     * @param ListVehicleQueryHandler $handler
     * @return Response
     */
    public function listAssignedVehicle(int $id, ListVehicleQueryHandler $handler): Response
    {
        $response = $handler->handle(new ListVehicleQuery($id));

        return $this->render('pages/movement/assignedVehicle.html.twig', [
            'movement' => $this->json($response->getMovement())->getContent()
        ]);
    }

    /**
     * @param DownloadExcelTemplateAssignVehiclesMovementCommandHandler $handler
     * @return StreamedResponse
     */
    final public function downloadAssignVehiclesTemplate(DownloadExcelTemplateAssignVehiclesMovementCommandHandler $handler): StreamedResponse
    {
        $response = $handler->handle();
        return Helpers::exportCsv([], $response->getHeaders(), $response->getFileName());
    }

    /**
     * @param Request $request
     * @param AssignVehicleCommandHandler $handler
     * @return Response
     */
    public function assignVehicle(Request $request, AssignVehicleCommandHandler $handler): Response
    {
        $command = new AssignVehicleCommand(
            $request->get('vehicleLinesId'),
            intval($request->get('vehiclesUnits')),
            intval($request->get('movementId'))
        );

        $response = $handler->handle($command);

        return $this->json(
            [
                'assigned' => $response->areAssigned(),
                'message' => $response->getMessage()
            ]
        );
    }

    public function assignVehicleCSV(Request $request, ProcessFileAssignVehicleMovementCommandHandler $handler): JsonResponse
    {
        try {
            $file = $request->files->get('fileCSV');
            $response = $handler->handle(new ProcessFileAssignVehicleMovementCommand(
                intval($request->get('movementId')),
                $file
            ));

            return $this->json([
                'status' => $response->isCompleted(),
                'messages' => $response->getMessages(),
                'affectedVehicles' => $response->getAffectedVehicles(),
            ], Response::HTTP_OK);
        } catch (AssignVehicleExcelException $e) {
            return $this->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'data' => $e->getData()
            ], $e->getCode());
        }
    }

    public function updateDateVehicleLine(Request $request, UpdateDateVehicleCommandHandler $commandHandler): Response
    {
        $command = new UpdateDateVehicleCommand(
            intval($request->get('movementId')),
            $request->get('vehicleIdList'),
            $request->get('actualLoadDate'),
            $request->get('actualUnloadDate')
        );

        $response = $commandHandler->handle($command);

        return $this->json(['datesUpdated' => $response->isUpdated()]);
    }

    /**
     * @param Request $request
     * @param DeleteVehicleMovementCommandHandler $handler
     * @return Response
     */
    public function deleteVehicleLine(Request $request, DeleteVehicleMovementCommandHandler $handler): Response
    {
        $command = new DeleteVehicleMovementCommand(
            intval($request->get('movementId')),
            is_array($request->get('vehicleIdList')) ? $request->get('vehicleIdList') : [$request->get('vehicleIdList')]
        );

        $response = $handler->handle($command);

        return $this->json(
            [
                'id' => $response->getId(),
                'message' => $response->getMessage(),
                'deleted' => $response->wasSuccess(),
            ],
            !$response->wasSuccess() ? $response->getCode() : 200
        );
    }

    /**
     * @param Request $request
     * @param GetAutomaticCostCommandHandler $handler
     * @return Response
     */
    public function automaticCost(Request $request, GetAutomaticCostCommandHandler $handler): Response
    {
        $command = new GetAutomaticCostCommand(
            intval($request->get('originBranchId')) ?? null,
            intval($request->get('destinationBranchId')) ?? null,
            intval($request->get('providerId')) ?? null,
            intval($request->get('transportMethodId')) ?? null,
            intval($request->get('vehicleUnits')) ?? null
        );

        $response = $handler->handle($command);

        return $this->json($response->getAutomaticCost());
    }

    /**
     * @param Request $request
     * @param GetLocationsQueryHandler $handler
     * @return JsonResponse
     *
     * @throws LocationException
     */
    public function getLocations(Request $request, GetLocationsQueryHandler $handler): JsonResponse
    {
        $locationType = null;
        if ($request->get('locationType')) {
            $locationType = !is_array($request->get('locationType')) ? [$request->get('locationType')] : $request->get('locationType');
        }
        $branchId = $request->get('branchId') && is_numeric($request->get('branchId')) ? intval($request->get('branchId')) : null;

        $query = new GetLocationsQuery(
            $locationType,
            $branchId
        );

        $response = $handler->handle($query);

        return $this->json($response->getLocationsArray(), count($response->getLocationsArray()) > 0 ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    /**
     * @param Request $request
     * @param GetExternalLocationsQueryHandler $handler
     * @return JsonResponse
     *
     * @throws LocationException
     */
    public function getExternalLocations(Request $request, GetExternalLocationsQueryHandler $handler): JsonResponse
    {
        $query = new GetExternalLocationsQuery(intval($request->get('providerId')));

        $response = $handler->handle($query);

        return $this->json($response->getExternalLocationsArray(), count($response->getExternalLocationsArray()) > 0 ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // FIXME refactorizar como getLocations y getExternalLocations
    public function getDestinations(Request $request, GetDestinationsQueryHandler $handler)
    {
        $originId = is_numeric($request->get('idOrigin')) ? intval($request->get('idOrigin')) : null;
        $branchGroupId = is_numeric($request->get('branchGroupId')) ? intval($request->get('branchGroupId')) : null;
        $locationTypeId = $request->get('locationTypeId') ?: null;


        try {
            $response = $handler->handle(new GetDestinationsQuery($locationTypeId, $originId, $branchGroupId));
            return $this->json($response->getDestinations());
        } catch (LocationException $e) {
            $this->get('session')->getFlashBag()->add(self::$FLASH_WARNING, 'Ha habido un problema al buscar las localizaciones');
            return Response::create('error');
        }
    }

    /**
     * @throws MovementException
     */
    public function downloadExcelMovement(Request $request, FilterMovementQueryHandler $handler): StreamedResponse
    {
        //Exportar excel según filtros
        $filters = $request->get('filters');

        $movementStatus = null;
        if (isset($filters['movementStatusId'])) {
            $movementStatus = is_array($filters['movementStatusId']) ? $filters['movementStatusId'] : [$filters['movementStatusId']];
        }

        $query = new FilterMovementQuery(
            null,
            null,
            null,
            null,
            isset($filters['movementTypeId']) ? intval($filters['movementTypeId']) : null,
            $filters['movementCategory'] ?? null,
            $movementStatus,
            isset($filters['orderMovement']) ? [$filters['orderMovement']] : null,
            isset($filters['orderNumber']) ? [$filters['orderNumber']] : null,
            $filters['extTransport'] ?? null,
            $filters['licensePlate'] ?? null,
            $filters['vin'] ?? null,
            $filters['brandId'] ?? null,
            $filters['modelId'] ?? null,
            $filters['supplierCode'] ?? null,
            $filters['originLocationId'] ?? null,
            null,
            $filters['destinationLocationId'] ?? null,
            null,
            $filters['originBranchId'] ?? null,
            $filters['destinationBranchId'] ?? null,
            $filters['businessUnitId'] ?? null,
            $filters['businessUnitArticleId'] ?? null,
            null,
            null,
            null,
            null,
            null,
            null,
            $filters['expectedLoadDateFrom'] ?? null,
            $filters['expectedLoadDateTo'] ?? null,
            $filters['expectedUnloadDateFrom'] ?? null,
            $filters['expectedUnloadDateTo'] ?? null,
            $filters['actualLoadDateFrom'] ?? null,
            $filters['actualLoadDateTo'] ?? null,
            $filters['actualUnloadDateFrom'] ?? null,
            $filters['actualUnloadDateTo'] ?? null,
            null,
            null
        );

        $response = $handler->handle($query, true, 'movement');
        $movement = $response->getMovementResponse();

        return Helpers::exportCsv(
            $movement['rows'],
            null,
            'movement.csv'
        );
    }

    /**
     * @param Request $request
     * @param FilterMovementQueryHandler $handler
     * 
     * @throws MovementException
     */
    public function downloadExcelVehicle(Request $request, FilterMovementQueryHandler $handler)
    {
        //Exportar excel según filtros
        $filters = $request->get('filters');

        $statusIn = $request->get('movementStatusId') ?
            (is_numeric($request->get('movementStatusId')) ?
                [intval($request->get('movementStatusId'))]
                : json_decode($request->get('movementStatusId', '[]'))
            ) : null;

        $query = new FilterMovementQuery(
            null,
            null,
            null,
            null,
            isset($filters['movementTypeId']) ? intval($filters['movementTypeId']) : null,
            isset($filters['movementCategory']) ? intval($filters['movementCategory']) : null,
            $statusIn,
            isset($filters['orderMovement']) ? [$filters['orderMovement']] : null,
            isset($filters['orderNumber']) ? [$filters['orderNumber']] : null,
            $filters['extTransport'] ?? null,
            $filters['licensePlate'] ?? null,
            $filters['vin'] ?? null,
            $filters['brandId'] ?? null,
            $filters['modelId'] ?? null,
            $filters['supplierCode'] ?? null,
            $filters['originLocationId'] ?? null,
            null,
            $filters['destinationLocationId'] ?? null,
            null,
            $filters['originBranchId'] ?? null,
            $filters['destinationBranchId'] ?? null,
            $filters['businessUnitId'] ?? null,
            $filters['businessUnitArticleId'] ?? null,
            null,
            null,
            null,
            null,
            null,
            null,
            $filters['expectedLoadDateFrom'] ?? null,
            $filters['expectedLoadDateTo'] ?? null,
            $filters['expectedUnloadDateFrom'] ?? null,
            $filters['expectedUnloadDateTo'] ?? null,
            $filters['actualLoadDateFrom'] ?? null,
            $filters['actualLoadDateTo'] ?? null,
            $filters['actualUnloadDateFrom'] ?? null,
            $filters['actualUnloadDateTo'] ?? null,
            null,
            null
        );

        try {
            $response = $handler->handle($query, true, 'vehicle');
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
        $vehicle = $response->getMovementResponse();

        return Helpers::exportCsv(
            $vehicle['rows'],
            null,
            'vehicleMovement.csv'
        );
    }

    public function getMovement(int $id, GetByIdMovementQueryHandler $handler): Response
    {
        $response = $handler->handle($id);

        return $this->json($response->getMovement());
    }

    /**
     * @throws MovementException
     */
    public function getPdf($id, Request $request, GetByIdPdfMovementCommandHandler $commandHandler)
    {
        //        $id = $request->get('id');
        $response = $commandHandler->handle(new GetByIdPdfMovementCommand(intval($id)));

        $this->generatePdf($response->getMovementTypeId(), $response->getMovement());
    }

    private function generatePdf($movementType, array $movement)
    {
        $constantsManager = json_decode(ConstantsJsonFile::getAllConstants(), true);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        // Crea una instancia de Dompdf con nuestras opciones
        $domPdf = new Dompdf($pdfOptions);
        $html = $this->renderView('pages/movement/pdf.html.twig', compact('movement', 'movementType', 'constantsManager'));
        $domPdf->loadHtml($html);
        $domPdf->setPaper('A4', 'landscape');
        $domPdf->render();
        $domPdf->stream('movement_' . $movement['id'] . '.pdf', [
            'Attachment' => true
        ]);
    }
}
