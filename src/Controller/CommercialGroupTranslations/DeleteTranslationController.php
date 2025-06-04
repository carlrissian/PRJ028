<?php
declare(strict_types=1);

namespace App\Controller\CommercialGroupTranslations;

use App\Controller\Controller;
use Distribution\CommercialGroupTranslations\Application\DeleteCommercialGroupTranslations\DeleteCommercialGroupTranslationsCommand;
use Distribution\CommercialGroupTranslations\Application\DeleteCommercialGroupTranslations\DeleteCommercialGroupTranslationsCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeleteTranslationController extends Controller
{
    private DeleteCommercialGroupTranslationsCommandHandler $handler;
    public function __construct(DeleteCommercialGroupTranslationsCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $translationId = intval($request->get('id'));

        $response = $this->handler->handle(new DeleteCommercialGroupTranslationsCommand($translationId));

        return $this->json([ 'status' => $response->getStatus(), 'message' => $response->getMessage() ] );
    }
}