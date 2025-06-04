<?php
declare(strict_types=1);

namespace App\Controller\AcrissBranchTranslations;

use App\Controller\Controller;
use Distribution\AcrissBranchTranslations\Application\StoreAcrissBranch\StoreAcrissBranchCommand;
use Distribution\AcrissBranchTranslations\Application\StoreAcrissBranch\StoreAcrissBranchCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class StoreBranchController extends Controller
{
    private StoreAcrissBranchCommandHandler $handler;
    public function __construct(StoreAcrissBranchCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        // TODO Sustituir usuario creación cuando esté login
        $userId = $this->getUser();
        $userId = 1;

        $command = new StoreAcrissBranchCommand($request->get('acrissId'), $request->get('branchId'), $request->get('commercialName'), $request->get('default'), $userId);

        $response = $this->handler->handle($command);

        return $this->json([ 'id' => $response->getId(),'status' => $response->getStatus(), 'message' => $response->getMessage()] );
    }
}