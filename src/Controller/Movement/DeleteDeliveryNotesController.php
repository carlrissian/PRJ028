<?php

namespace App\Controller\Movement;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Movement\Application\DeleteDeliveryNotes\DeleteDeliveryNotesCommand;
use Distribution\Movement\Application\DeleteDeliveryNotes\DeleteDeliveryNotesMovementCommandHandler;

class DeleteDeliveryNotesController extends AbstractController
{
    /**
     * @var DeleteDeliveryNotesMovementCommandHandler
     */
    private $handler;

    /**
     * @param DeleteDeliveryNotesMovementCommandHandler $handler
     */
    public function __construct(DeleteDeliveryNotesMovementCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * 
     * @throws VehicleNotFoundException
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $command = new DeleteDeliveryNotesCommand(
                intval($request->get('movementId')),
                intval($request->get('id'))
            );

            $response = $this->handler->handle($command);

            return $this->json([
                'deleted' => $response->isDeleted(),
            ], $response->isDeleted() ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return $this->json([
                'deleted' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
