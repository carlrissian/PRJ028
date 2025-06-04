<?php

declare(strict_types=1);

namespace App\Controller\Acriss;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Distribution\Acriss\Application\ShowAcriss\ShowAcrissQuery;
use Distribution\Acriss\Application\ShowAcriss\ShowAcrissQueryHandler;

class ShowAcrissController extends Controller
{
    /**
     * @var ShowAcrissQueryHandler
     */
    private ShowAcrissQueryHandler $handler;

    public function __construct(ShowAcrissQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(int $id): Response
    {
        $response = $this->handler->handle(new ShowAcrissQuery($id));

        return $this->render('pages/acriss/show.html.twig', ['acriss' => json_encode($response->getAcriss())]);
    }
}
