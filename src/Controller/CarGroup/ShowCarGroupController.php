<?php
declare(strict_types=1);

namespace App\Controller\CarGroup;

use App\Controller\Controller;
use Distribution\CarGroup\Application\ShowCarGroup\ShowCarGroupQuery;
use Distribution\CarGroup\Application\ShowCarGroup\ShowCarGroupQueryHandler;
use Symfony\Component\HttpFoundation\Response;

class ShowCarGroupController extends Controller
{

    public function show(int $id, ShowCarGroupQueryHandler $handler): Response
    {
        $response = $handler->handle(new ShowCarGroupQuery($id));

        return $this->render('pages/cargroup/show.html.twig', ['carGroup' => $this->json($response->getCarGroup())->getContent()]);
    }
}