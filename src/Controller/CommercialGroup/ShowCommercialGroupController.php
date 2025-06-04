<?php

declare(strict_types=1);

namespace App\Controller\CommercialGroup;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Distribution\CommercialGroup\Application\ShowCommercialGroup\ShowCommercialGroupQuery;
use Distribution\CommercialGroup\Application\ShowCommercialGroup\ShowCommercialGroupQueryHandler;

class ShowCommercialGroupController extends Controller
{
    /**
     * @var ShowCommercialGroupQueryHandler
     */
    private ShowCommercialGroupQueryHandler $handler;

    /**
     * constructor.
     *
     * @param ShowCommercialGroupQueryHandler $handler
     */
    public function __construct(ShowCommercialGroupQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param integer $id
     * @return Response
     */
    public function __invoke(int $id): Response
    {
        $response = $this->handler->handle(new ShowCommercialGroupQuery($id));

        return $this->render('pages/commercialgroup/details.html.twig', ['commercialGroup' => $this->json($response->getCommercialGroup())->getContent()]);
    }
}
