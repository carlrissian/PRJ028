<?php

declare(strict_types=1);

namespace App\Controller\ParameterSettings;

use App\Controller\Controller;
use Distribution\ParameterSetting\Application\ListParemeterSettingsSelects\ListParameterSettingsSelectsQueryHandler;
use Distribution\ParameterSetting\Application\ListParemeterSettingsSelects\ListParameterSettingsSelectsQuery;
use Symfony\Component\HttpFoundation\JsonResponse;

class ParameterSettingsListController extends Controller
{
    final public function getListFilters(ListParameterSettingsSelectsQueryHandler $listParameterSettingsSelectsQueryHandler): JsonResponse
    {
        //TODO Obtener id país desde donde se guarde tras LOGIN
        $countryId = $this->get('session')->get('countryId') ?: 1;

        $response = $listParameterSettingsSelectsQueryHandler->handle(new ListParameterSettingsSelectsQuery($countryId));

        // FIXME mover esta lógica al frontend
        return $this->json([
            'regions' => $response->getRegions(),
            'areas' => $response->getAreas(),
            'delegations' => $response->getDelegations(),
            'connectedVehicleList' => $response->getConnectedVehicleList(),
            'carGroupList' => $response->getCarGroupList(),
            'acrissList' => $response->getAcrissList(),
            'parameterSettingTypeList' => $response->getParameterSettingTypeList()
        ]);
    }
}
