<?php

namespace App\Controller\ParameterSettings;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\ParameterSetting\Application\ListParemeterSettingsSelects\ListParameterSettingsSelectsQuery;
use Distribution\ParameterSetting\Application\ListParemeterSettingsSelects\ListParameterSettingsSelectsQueryHandler;

class ParameterSettingsListController extends Controller
{
    final public function getListFilters(ListParameterSettingsSelectsQueryHandler $handler): JsonResponse
    {
        $query = new ListParameterSettingsSelectsQuery();
        $response = $handler->handle($query);
        return $this->json($response->getSelectList());
    }
}
