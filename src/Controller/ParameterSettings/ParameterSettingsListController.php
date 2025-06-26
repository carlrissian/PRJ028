<?php

namespace App\Controller\ParameterSettings;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Distribution\ParameterSetting\Application\ListParemeterSettingsSelects\ListParameterSettingsSelectsQuery;
use Distribution\ParameterSetting\Application\ListParemeterSettingsSelects\ListParameterSettingsSelectsQueryHandler;

class ParameterSettingsListController extends Controller
{
    final public function getListFilters(ListParameterSettingsSelectsQueryHandler $handler): Response
    {
        $query = new ListParameterSettingsSelectsQuery();
        $response = $handler->handle($query);

        return $this->render('pages/parameter_settings/list.html.twig', [
            'selectList' => $this->json($response->getSelectList())->getContent(),
        ]);
    }
}
