<?php
declare(strict_types=1);

namespace App\Controller\AcrissBranchTranslations;

use App\Controller\Controller;
use Distribution\AcrissBranchTranslations\Application\FilterAcrissBranch\FilterAcrissBranchQuery;
use Distribution\AcrissBranchTranslations\Application\FilterAcrissBranch\FilterAcrissBranchQueryHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FilterBranchController extends Controller
{
    private FilterAcrissBranchQueryHandler $handler;
    public function __construct(FilterAcrissBranchQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $acrissId = intval($request->get('acrissId'));

        $response = $this->handler->handle(new FilterAcrissBranchQuery($acrissId));

        return $this->json([ $response->getBranchArray() ] );
    }
}