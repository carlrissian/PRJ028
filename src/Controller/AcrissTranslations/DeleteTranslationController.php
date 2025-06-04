<?php
declare(strict_types=1);

namespace App\Controller\AcrissTranslations;

use App\Controller\Controller;
use Distribution\AcrissTranslations\Application\DeleteAcrissTranslations\DeleteAcrissTranslationsCommand;
use Distribution\AcrissTranslations\Application\DeleteAcrissTranslations\DeleteAcrissTranslationsCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeleteTranslationController extends Controller
{
    private DeleteAcrissTranslationsCommandHandler $handler;
    public function __construct(DeleteAcrissTranslationsCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $translationId = intval($request->get('id'));

        $response = $this->handler->handle(new DeleteAcrissTranslationsCommand($translationId));

        return $this->json([ 'status' => $response->getStatus(), 'message' => $response->getMessage() ] );
    }
}