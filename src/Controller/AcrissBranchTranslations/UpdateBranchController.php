<?php
declare(strict_types=1);

namespace App\Controller\AcrissBranchTranslations;

use App\Controller\Controller;
use Distribution\AcrissBranchTranslations\Application\UpdateAcrissBranch\UpdateAcrissBranchCommand;
use Distribution\AcrissBranchTranslations\Application\UpdateAcrissBranch\UpdateAcrissBranchCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateBranchController extends Controller
{
    private UpdateAcrissBranchCommandHandler $handler;
    public function __construct(UpdateAcrissBranchCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $updateUserId = 1;

        $command = new UpdateAcrissBranchCommand($request->get('id'), $request->get('acrissId'), $request->get('branchId'), $request->get('commercialName'), $request->get('default'), $updateUserId);
        $response = $this->handler->handle($command);

        return $this->json([ 'status' => $response->getStatus(), 'message' => $response->getMessage() ] );
    }
}