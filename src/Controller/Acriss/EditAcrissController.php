<?php

namespace App\Controller\Acriss;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Distribution\Acriss\Application\Details\DetailsAcrissQuery;
use Distribution\Acriss\Application\Details\DetailsAcrissQueryHandler;

class EditAcrissController extends Controller
{
    /**
     * @var DetailsAcrissQueryHandler
     */
    private $handler;

    /**
     * @param DetailsAcrissQueryHandler $handler
     */
    public function __construct(DetailsAcrissQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param integer $id
     * @return Response
     */
    public function __invoke(int $id): Response
    {
        $response = $this->handler->handle(new DetailsAcrissQuery($id));
        return $this->render('pages/acriss/edit.html.twig', ['acriss' => $this->json([
            "data" => $response->getAcriss(),
            "branchTranslations" => $response->getBranchTranslations(),
        ])->getContent()]);
    }
}
