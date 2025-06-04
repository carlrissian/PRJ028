<?php

namespace App\Controller\ParameterSettings;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\ParameterSetting\Application\FilterParameterSettings\FilterParameterSettingsQuery;
use Distribution\ParameterSetting\Application\FilterParameterSettings\FilterParameterSettingsQueryHandler;

class FilterController extends AbstractController
{
    /**
     * @var FilterParameterSettingsQueryHandler
     */
    private FilterParameterSettingsQueryHandler $handler;

    /**
     * @param FilterParameterSettingsQueryHandler $handler
     */
    public function __construct(FilterParameterSettingsQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        //TODO Obtener id país desde donde se guarde tras LOGIN
        $countryId = $this->get('session')->get('countryId') ?: 1;

        $query = new FilterParameterSettingsQuery(
            intval($request->get('limit')),
            intval($request->get('offset')),
            $request->get('sort'),
            $request->get('order'),
            $request->get('acrissIds') ? json_decode($request->get('acrissIds')) : null,
            $request->get('substitutionAcrissIds') ? json_decode($request->get('substitutionAcrissIds')) : null,
            $request->get('regionIds') ? json_decode($request->get('regionIds')) : null,
            $request->get('areaIds') ? json_decode($request->get('areaIds')) : null,
            $request->get('branchIds') ? json_decode($request->get('branchIds')) : null,
            $request->get('parameterSettingTypeId') ? intval($request->get('parameterSettingTypeId')) : null,
            !is_null($request->get('connectedVehicle')) ? filter_var($request->get('connectedVehicle'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null,
            $countryId,
            $request->get('startDate'),
            $request->get('endDate'),
            $request->get('creationDateFrom'),
            $request->get('creationDateTo'),
            $request->get('creationTimeFrom'),
            $request->get('creationTimeTo')
        );

        $response = $this->handler->handle($query);

        return $this->json($response->getParameterSettingResponse());
    }
}
