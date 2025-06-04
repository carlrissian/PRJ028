<?php
declare(strict_types=1);

namespace App\Controller\AcrissImageLinesTranslations;

use App\Controller\Controller;
use Distribution\AcrissImageLine\Application\StoreAcrissImageLine\StoreAcrissImageLineCommand;
use Distribution\AcrissImageLine\Application\StoreAcrissImageLine\StoreAcrissImageLineCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class StoreImageLineController extends Controller
{
    private StoreAcrissImageLineCommandHandler $handler;
    public function __construct(StoreAcrissImageLineCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        //TODO cambiar cuando tengamos usuario de login
        $creationUserId = 1;

        $command = new StoreAcrissImageLineCommand($request->get('acrissId'), $request->get('branchId'), $request->get('index'), $request->get('description'), $request->getContent('url'), $creationUserId);
        $response = $this->handler->handle($command);

        return $this->json([ 'status' => $response->getStatus(), 'message' => $response->getMessage(), 'id' => $response->getId() ] );
    }
}