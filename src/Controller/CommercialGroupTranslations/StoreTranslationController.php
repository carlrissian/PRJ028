<?php
declare(strict_types=1);

namespace App\Controller\CommercialGroupTranslations;

use App\Controller\Controller;
use Distribution\CommercialGroupTranslations\Application\StoreCommercialGroupTranslations\StoreCommercialGroupTranslationsCommand;
use Distribution\CommercialGroupTranslations\Application\StoreCommercialGroupTranslations\StoreCommercialGroupTranslationsCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class StoreTranslationController extends Controller
{
    private StoreCommercialGroupTranslationsCommandHandler $handler;
    public function __construct(StoreCommercialGroupTranslationsCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        //  TODO sustituir por usuario login
        $creationUserId = 1;

        $commercialGroupId = $request->get('commercialGroupId');
        $languageId = $request->get('languageId');
        $languageCode = $request->get('languageCode');
        $translation = $request->get('translation');
        $default = $request->get('default');
        $command = new StoreCommercialGroupTranslationsCommand($commercialGroupId,  $languageId, $languageCode, $translation,$default, $creationUserId);
        $response = $this->handler->handle($command);

        return $this->json([ 'status' => $response->getStatus(), 'message' => $response->getMessage(), 'id' => $response->getId() ] );
    }
}