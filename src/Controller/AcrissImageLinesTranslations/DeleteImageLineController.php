<?php
declare(strict_types=1);

namespace App\Controller\AcrissImageLinesTranslations;

use App\Controller\Controller;
use Distribution\AcrissImageLine\Application\DeleteAcrissImageLine\DeleteAcrissImageLineCommand;
use Distribution\AcrissImageLine\Application\DeleteAcrissImageLine\DeleteAcrissImageLineCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeleteImageLineController extends Controller
{
    private DeleteAcrissImageLineCommandHandler $handler;
    public function __construct(DeleteAcrissImageLineCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $imageLineId = intval($request->get('id'));

        $response = $this->handler->handle(new DeleteAcrissImageLineCommand($imageLineId));

        return $this->json([ 'status' => $response->getStatus(), 'message' => $response->getMessage() ] );
    }
}