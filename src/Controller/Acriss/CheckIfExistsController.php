<?php

namespace App\Controller\Acriss;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Acriss\Application\CheckIfAcrissExists\CheckIfAcrissExistsQuery;
use Distribution\Acriss\Application\CheckIfAcrissExists\CheckIfAcrissExistsQueryHandler;

class CheckIfExistsController extends AbstractController
{
    /**
     * @var CheckIfAcrissExistsQueryHandler
     */
    private $handler;

    /**
     * @param CheckIfAcrissExistsQueryHandler $handler
     */
    public function __construct(CheckIfAcrissExistsQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $query = new CheckIfAcrissExistsQuery($request->get('acriss'));

        $response = $this->handler->handle($query);

        return $this->json(['acrissExists' => $response->acrissExists()]);
    }
}
