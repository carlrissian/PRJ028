<?php

namespace App\Controller\Movement;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Movement\Application\UpdateDeliveryNotes\UpdateDeliveryNotesMovementCommand;
use Distribution\Movement\Application\UpdateDeliveryNotes\UpdateDeliveryNotesMovementCommandHandler;

class UpdateDeliveryNotesController extends AbstractController
{
    /**
     * @var UpdateDeliveryNotesMovementCommandHandler
     */
    private $handler;

    /**
     * @param UpdateDeliveryNotesMovementCommandHandler $handler
     */
    public function __construct(UpdateDeliveryNotesMovementCommandHandler $handler)
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
            $file = file_get_contents($request->files->get('file')->getPathname());
            $fileType = $request->files->get('file')->getClientMimeType();
            $base64File = base64_encode($file);

            $movementId = intval($request->get('movementId'));
            $typeName = $request->get('typeName');

            $command = new UpdateDeliveryNotesMovementCommand(
                $movementId,
                $request->get('id') ? intval($request->get('id')) : null,
                intval($request->get('typeId')),
                $request->get('typeName'),
                $base64File
            );

            $response = $this->handler->handle($command);

            return $this->json([
                'uploaded' => $response->isUploaded(),
                'file' => $base64File,
                'fileType' => $fileType,
                'name' => sprintf("Albaran_%d_%s_%s", $movementId, $typeName, date('d-m-Y')),
                'message' => $response->getMessage(),
            ], !$response->isUploaded() ? $response->getCode() : Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'uploaded' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
