<?php
declare(strict_types=1);

namespace App\Controller\AcrissBranchTranslations;

use App\Controller\Controller;
use Distribution\AcrissBranchTranslations\Application\DeleteAcrissBranch\DeleteAcrissBranchCommand;
use Distribution\AcrissBranchTranslations\Application\DeleteAcrissBranch\DeleteAcrissBranchCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeleteBranchController extends Controller
{
    private DeleteAcrissBranchCommandHandler $handler;
    public function __construct(DeleteAcrissBranchCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $branchTranslationId = intval($request->get('id'));

        $response = $this->handler->handle(new DeleteAcrissBranchCommand($branchTranslationId));

        return $this->json([ 'status' => $response->getStatus(), 'message' => $response->getMessage() ] );
    }
}