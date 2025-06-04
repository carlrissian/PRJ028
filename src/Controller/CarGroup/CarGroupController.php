<?php
declare(strict_types=1);


namespace App\Controller\CarGroup;


use App\Controller\Controller;
use Distribution\CarGroup\Application\CreateCarGroup\CreateCarGroupQuery;
use Distribution\CarGroup\Application\CreateCarGroup\CreateCarGroupQueryHandler;
use Distribution\CarGroup\Application\StoreCarGroup\StoreCarGroupCommand;
use Distribution\CarGroup\Application\StoreCarGroup\StoreCarGroupCommandHandler;
use Distribution\CarGroup\Application\UpdateCarGroup\UpdateCarGroupCommand;
use Distribution\CarGroup\Application\UpdateCarGroup\UpdateCarGroupCommandHandler;
use Distribution\Shared\Domain\RepositoryException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CarGroupController
 * @package App\Controller\CarGroup
 */
class CarGroupController extends Controller
{
    /**
     * @var string
     */
    public static string $FLASH_OK = 'success';
    /**
     * @var string
     */
    public static string $FLASH_WARNING = 'warning';

    private static string $CAR_GROUP_CREATE_ROUTE = 'cargroup.create';
    private static string $CAR_GROUP_LIST_ROUTE = 'cargroup.list';

    /**
     * @return Response
     */
    public function create(CreateCarGroupQueryHandler $handler): Response
    {
        $response = $handler->handle(new CreateCarGroupQuery());

        $responseJson = $this->json([
            'acrissList' => $response->getAcrissList(),
        ]);

        return $this->render('pages/cargroup/create.html.twig',  ['selectList' => $responseJson->getContent()]);
    }

    /**
     * @param Request $request
     * @param StoreCarGroupCommandHandler $storeGroupCommandHandler
     * @return JsonResponse
     */
    public function store(Request $request, StoreCarGroupCommandHandler $storeGroupCommandHandler): JsonResponse
    {
        $groupCommand = new StoreCarGroupCommand(
            $request->get('carGroupName'),
            (int) $request->get('acrissId')
        );

        try {
            $response = $storeGroupCommandHandler->handle($groupCommand);

        } catch (RepositoryException $e) {
            return $this->json(['status' => 'warning', 'message' => $e->getMessage()]);
        }

        return $this->json(['status' => 'success', 'message' => 'Se ha creado el grupo correctamente']);
    }

    /**
     * @param Request $request
     * @param UpdateCarGroupCommandHandler $editCarGroupCommandHandler
     * @return JsonResponse
     */
    public function update(Request $request, UpdateCarGroupCommandHandler $updateCarGroupCommandHandler): JsonResponse
    {
        $groupCommand = new UpdateCarGroupCommand(
            (int) $request->get('carGroupId'),
            $request->get('carGroupName')
        );

        try {
            $response = $updateCarGroupCommandHandler->handle($groupCommand);
        } catch (RepositoryException $e) {
            return $this->json(['status' => 'warning', 'message' => $e->getMessage()]);
        }

        return $this->json(['status' => 'success', 'message' => 'Se ha actualizado Grupo flota correctamente']);
    }


}
