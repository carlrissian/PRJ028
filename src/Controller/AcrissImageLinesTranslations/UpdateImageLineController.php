<?php
declare(strict_types=1);

namespace App\Controller\AcrissImageLinesTranslations;

use App\Controller\Controller;
use Distribution\AcrissImageLine\Application\UpdateAcrissImageLine\UpdateAcrissImageLineCommand;
use Distribution\AcrissImageLine\Application\UpdateAcrissImageLine\UpdateAcrissImageLineCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateImageLineController extends Controller
{
    private UpdateAcrissImageLineCommandHandler $handler;
    public function __construct(UpdateAcrissImageLineCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        //TODO cambiar cuando tengamos usuario de login
        $creationUserId = 1;

        $command = new UpdateAcrissImageLineCommand($request->get('id'), $request->get('acrissId'), $request->get('branchId'), $request->get('index'), $request->get('description'), $request->getContent('url'), $creationUserId);
        $response = $this->handler->handle($command);

        return $this->json([ 'status' => $response->getStatus(), 'message' => $response->getMessage() ] );
    }
}