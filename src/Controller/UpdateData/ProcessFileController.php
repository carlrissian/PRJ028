<?php

namespace App\Controller\UpdateData;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\UpdateData\Domain\UpdateDataExcelException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\UpdateData\Application\ProcessFileUpdateData\ProcessFileUpdateDataCommand;
use Distribution\UpdateData\Application\ProcessFileUpdateData\ProcessFileUpdateDataCommandHandler;

class ProcessFileController extends AbstractController
{
    /**
     * @return Response
     */
    public function __invoke(Request $request, ProcessFileUpdateDataCommandHandler $handler): JsonResponse
    {
        try {
            $file = $request->files->get('uploadExcel');
            $response = $handler->handle(new ProcessFileUpdateDataCommand($file));

            return $this->json($response, $response->isSuccess() ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (UpdateDataExcelException $e) {
            return $this->json([
                'message' => $e->getMessage(),
                'vehicles' => $e->getData(),
            ], $e->getCode());
        }
    }
}
