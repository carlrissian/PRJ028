<?php
declare(strict_types=1);

namespace App\Controller\CarGroup;

use App\Controller\Controller;
use Distribution\CarGroup\Application\EditCarGroup\EditCarGroupQuery;
use Distribution\CarGroup\Application\EditCarGroup\EditCarGroupQueryHandler;
use Symfony\Component\HttpFoundation\Response;

class EditCarGroupController extends Controller
{

    public function edit(int $id, EditCarGroupQueryHandler $handler): Response
    {
        $response = $handler->handle(new EditCarGroupQuery($id));

        return $this->render('pages/cargroup/edit.html.twig', ['carGroup' => $this->json($response->getCarGroup())->getContent()]);
    }
}