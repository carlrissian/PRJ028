<?php

namespace App\Controller\Acriss;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Acriss\Application\CheckIfAcrissHasChilds\CheckIfAcrissHasChildsQuery;
use Distribution\Acriss\Application\CheckIfAcrissHasChilds\CheckIfAcrissHasChildsQueryHandler;

class CheckIfHasChildsController extends AbstractController
{
    /**
     * @var CheckIfAcrissHasChildsQueryHandler
     */
    private $handler;

    /**
     * @param CheckIfAcrissHasChildsQueryHandler $handler
     */
    public function __construct(CheckIfAcrissHasChildsQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $query = new CheckIfAcrissHasChildsQuery(
            $request->get('acrissFirstLetter'),
            $request->get('acrissSecondLetter'),
            $request->get('acrissThirdLetter')
        );

        $response = $this->handler->handle($query);

        return $this->json(['acrissHasChilds' => $response->acrissHasChilds()]);
    }
}
