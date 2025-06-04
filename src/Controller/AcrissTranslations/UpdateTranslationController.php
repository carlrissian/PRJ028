<?php
declare(strict_types=1);

namespace App\Controller\AcrissTranslations;

use App\Controller\Controller;
use Distribution\AcrissTranslations\Application\UpdateAcrissTranslations\UpdateAcrissTranslationsCommand;
use Distribution\AcrissTranslations\Application\UpdateAcrissTranslations\UpdateAcrissTranslationsCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateTranslationController extends Controller
{
    private UpdateAcrissTranslationsCommandHandler $handler;
    public function __construct(UpdateAcrissTranslationsCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        //  TODO sustituir por usuario login
        $creationUserId = 1;

        $id = $request->get('id');
        $acrissId = $request->get('acrissId');
        $branchId =  $request->get('branchId');
        $languageId = $request->get('languageId');
        $languageCode = $request->get('languageCode');
        $translation = $request->get('translation');
        $default = $request->get('default');
        $command = new UpdateAcrissTranslationsCommand($id, $acrissId, $branchId, $languageId, $languageCode, $translation,$default, $creationUserId);
        $response = $this->handler->handle($command);

        return $this->json([ 'status' => $response->getStatus(), 'message' => $response->getMessage() ] );
    }
}