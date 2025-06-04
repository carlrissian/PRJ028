<?php
declare(strict_types=1);

namespace App\Controller\AcrissTranslations;

use App\Controller\Controller;
use Distribution\AcrissTranslations\Application\StoreAcrissTranslations\StoreAcrissTranslationsCommand;
use Distribution\AcrissTranslations\Application\StoreAcrissTranslations\StoreAcrissTranslationsCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class StoreTranslationController extends Controller
{
    private StoreAcrissTranslationsCommandHandler $handler;
    public function __construct(StoreAcrissTranslationsCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        //  TODO sustituir por usuario login
        $creationUserId = 1;

        $acrissId = $request->get('acrissId');
        $branchId =  $request->get('branchId');
        $languageId = $request->get('languageId');
        $languageCode = $request->get('languageCode');
        $translation = $request->get('translation');
        $default = $request->get('default');
        $command = new StoreAcrissTranslationsCommand($acrissId, $branchId, $languageId, $languageCode, $translation,$default, $creationUserId);
        $response = $this->handler->handle($command);

        return $this->json([ 'status' => $response->getStatus(), 'message' => $response->getMessage(), 'id' => $response->getId() ] );
    }
}