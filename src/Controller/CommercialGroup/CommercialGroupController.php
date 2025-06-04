<?php

namespace App\Controller\CommercialGroup;

use Exception;
use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\CommercialGroup\Application\EditCommercialGroup\EditCommercialGroupQuery;
use Distribution\CommercialGroup\Application\CreateCommercialGroup\CreateCommercialGroupQuery;
use Distribution\CommercialGroup\Application\FilterCommercialGroup\FilterCommercialGroupQuery;
use Distribution\CommercialGroup\Application\DeleteCommercialGroup\DeleteCommercialGroupCommand;
use Distribution\CommercialGroup\Application\UpdateCommercialGroup\UpdateCommercialGroupCommand;
use Distribution\CommercialGroup\Application\EditCommercialGroup\EditCommercialGroupQueryHandler;
use Distribution\CommercialGroup\Application\CreateCommercialGroup\CreateCommercialGroupQueryHandler;
use Distribution\CommercialGroup\Application\FilterCommercialGroup\FilterCommercialGroupQueryHandler;
use Distribution\CommercialGroup\Application\DeleteCommercialGroup\DeleteCommercialGroupCommandHandler;
use Distribution\CommercialGroup\Application\UpdateCommercialGroup\UpdateCommercialGroupCommandHandler;

class CommercialGroupController extends Controller
{
    /**
     * @var string
     */
    public static string $FLASH_OK = 'success';

    /**
     * @var string
     */
    public static string $FLASH_WARNING = 'warning';

    /**
     * @param CreateCommercialGroupQueryHandler $handler
     * @return Response
     */
    public function create(CreateCommercialGroupQueryHandler $handler): Response
    {
        $response = $handler->handle(new CreateCommercialGroupQuery());

        $responseJson = $this->json([
            'acrissList' => $response->getAcrissList()
        ]);

        return $this->render('pages/commercialgroup/create.html.twig', ['selectList' => $responseJson->getContent()]);
    }

    /**
     * @return Response
     */
    public function edit(int $id, EditCommercialGroupQueryHandler $handler): Response
    {
        $response = $handler->handle(new EditCommercialGroupQuery($id));

        return $this->render('pages/commercialgroup/edit.html.twig', ['data' => $this->json($response->getData())->getContent()]);
    }

    /**
     * @param Request $request
     * @param FilterCommercialGroupQueryHandler $commercialGroupHandler
     * @return JsonResponse
     */
    public function filter(Request $request, FilterCommercialGroupQueryHandler $commercialGroupHandler): JsonResponse
    {
        $query = new FilterCommercialGroupQuery(
            $request->get('limit'),
            $request->get('offset'),
            ($request->get('commercialGroupIds')) ? json_decode($request->get('commercialGroupIds')) : null,
            $request->get('acrissName'),
            ($request->get('status')) ? filter_var($request->get('status'), FILTER_VALIDATE_BOOLEAN) : null
        );

        $response = $commercialGroupHandler->handle($query);

        return $this->json([
            'total' => $response->getTotalRow(),
            'rows' => $response->getCommercialGroupList()
        ]);
    }

    /**
     * @param Request $request
     * @param UpdateCommercialGroupCommandHandler $handler
     * @return JsonResponse
     */
    public function update(Request $request, UpdateCommercialGroupCommandHandler $handler): JsonResponse
    {
        $response = $handler->handle(new UpdateCommercialGroupCommand(json_decode($request->get('commercialGroup'), true)));

        return $this->json([
            'updated' => $response->isUpdated(),
            'nameExists' => $response->nameExists(),
        ]);
    }

    /**
     * @param Request $request
     * @param DeleteCommercialGroupCommandHandler $handler
     * @return JsonResponse
     */
    public function delete(Request $request, DeleteCommercialGroupCommandHandler $handler): JsonResponse
    {
        $commercialGroupCommand = new DeleteCommercialGroupCommand($request->get('id'));

        $response = $handler->handle($commercialGroupCommand);

        $this->get('session')->getFlashBag()->add(
            (($response->isDeleted()) ? self::$FLASH_OK : self::$FLASH_WARNING),
            (($response->isDeleted()) ? 'Se ha eliminado el grupo comercial correctamente' : 'Ha habido un problema al eliminar el grupo comercial')
        );

        return $this->json(['deleted' => $response->isDeleted()]);
    }
}
