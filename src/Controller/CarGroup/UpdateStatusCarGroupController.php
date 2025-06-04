<?php
declare(strict_types=1);

namespace App\Controller\CarGroup;

use App\Controller\Controller;
use Distribution\CarGroup\Application\UpdateStatusCarGroup\UpdateStatusCarGroupCommand;
use Distribution\CarGroup\Application\UpdateStatusCarGroup\UpdateStatusCarGroupCommandHandler;
use Distribution\Shared\Domain\RepositoryException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateStatusCarGroupController extends Controller
{

    /**
     * @throws RepositoryException
     */
    public function updateStatus(Request $request, UpdateStatusCarGroupCommandHandler $handler): JsonResponse
    {
        $carGroupId = (int) $request->get('carGroupId');
        $status = $request->get('status') == 'true';

        $response = $handler->handle(new UpdateStatusCarGroupCommand($carGroupId, $status));

        return $this->json(['status' => $response->getStatus(), 'message' => $response->getMessage()] );
    }
}