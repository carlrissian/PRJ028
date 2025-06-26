<?php
declare(strict_types=1);

namespace App\Controller\Acriss;

use App\Controller\Controller;
use Distribution\Acriss\Application\EditAcriss\EditAcrissQuery;
use Distribution\Acriss\Application\EditAcriss\EditAcrissQueryHandler;
use Symfony\Component\HttpFoundation\Response;

class EditAcrissController extends Controller
{

    /*public function edit(int $id, EditAcrissQueryHandler $editAcrissCommandHandler): Response
    {
        $response = $editAcrissCommandHandler->handle(new EditAcrissQuery($id));
        $responseJson = $this->json([
            'acriss' => $response->getAcriss(),
            'branchTranslations' => $response->getBranchTranslations(),
            'carClassList' => $response->getCarClassList(),
            'typeList' => $response->getAcrissTypeList(),
            'gearBoxList' => $response->getGearBoxList(),
            'motorizationList' => $response->getMotorizationList(),
            'branchList' => $response->getBranchList(),
        ]);
        return $this->render('pages/acriss/edit.html.twig', ['acrissData' => $responseJson->getContent()]);

    }*/
}