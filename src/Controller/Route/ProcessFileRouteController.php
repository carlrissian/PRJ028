<?php

namespace App\Controller\Route;

use Symfony\Component\HttpFoundation\Request;
use Distribution\Route\Domain\RouteExcelException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Route\Application\ProcessFileRoute\ProcessFileRouteCommand;
use Distribution\Route\Application\ProcessFileRoute\ProcessFileRouteCommandHandler;

class ProcessFileRouteController extends AbstractController
{
    /**
     * @var ProcessFileRouteCommandHandler
     */
    private ProcessFileRouteCommandHandler $handler;

    /**
     * @param ProcessFileRouteCommandHandler $handler
     */
    public function __construct(ProcessFileRouteCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $file = $request->files->get('fileCSV');
            $response = $this->handler->handle(new ProcessFileRouteCommand($file));

            return $this->json([
                'status' => $response->isCompleted(),
                'messages' => $response->getMessages(),
                'affectedRoutes' => $response->getAffectedRoutes(),
            ], 200);
        } catch (RouteExcelException $e) {
            return $this->json(['status' => false, 'code' => $e->getCode(), 'messages' => $e->getData()], $e->getCode());
        }
    }
}
