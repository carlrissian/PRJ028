<?php
declare(strict_types=1);

namespace App\Controller\CommercialGroupTranslations;

use App\Controller\Controller;
use Distribution\CommercialGroupTranslations\Application\UpdateCommercialGroupTranslations\UpdateCommercialGroupTranslationsCommand;
use Distribution\CommercialGroupTranslations\Application\UpdateCommercialGroupTranslations\UpdateCommercialGroupTranslationsCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateTranslationController extends Controller
{
    private UpdateCommercialGroupTranslationsCommandHandler $handler;
    public function __construct(UpdateCommercialGroupTranslationsCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        //  TODO sustituir por usuario login
        $creationUserId = 1;

        $id = $request->get('id');
        $commercialGroupId = $request->get('commercialGroupId');
        $languageId = $request->get('languageId');
        $languageCode = $request->get('languageCode');
        $translation = $request->get('translation');
        $default = $request->get('default');
        $command = new UpdateCommercialGroupTranslationsCommand($id, $commercialGroupId,  $languageId, $languageCode, $translation,$default, $creationUserId);
        $response = $this->handler->handle($command);

        return $this->json([ 'status' => $response->getStatus(), 'message' => $response->getMessage() ] );
    }
}