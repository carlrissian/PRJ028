<?php

declare(strict_types=1);

namespace App\Controller\ParameterSettings;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Distribution\ParameterSetting\Application\CreateParameterSetting\CreateParameterSettingQuery;
use Distribution\ParameterSetting\Application\StoreParameterSetting\StoreParameterSettingCommand;
use Distribution\ParameterSetting\Application\CreateParameterSetting\CreateParameterSettingQueryHandler;
use Distribution\ParameterSetting\Application\DeleteParameterSetting\DeleteParameterSettingCommand;
use Distribution\ParameterSetting\Application\DeleteParameterSetting\DeleteParameterSettingCommandHandler;
use Distribution\ParameterSetting\Application\StoreParameterSetting\StoreParameterSettingCommandHandler;

class ParameterSettingsController extends Controller
{
    /**
     * @param CreateParameterSettingQueryHandler $handler
     * @return Response
     */
    public function create(CreateParameterSettingQueryHandler $handler): Response
    {
        $query = new CreateParameterSettingQuery();
        $response = $handler->handle($query);
        
        return $this->render('pages/parameter_settings/create.html.twig', [
            'selectList' => $this->json($response->getSelectList())->getContent(),
        ]);
    }

    /**
     * @param Request $request
     * @param StoreParameterSettingCommandHandler $handler
     * @return RedirectResponse
     */
    public function store(Request $request, StoreParameterSettingCommandHandler $handler): Response
    {
        try{

            $command = new StoreParameterSettingCommand(
                $request->get('startDate'),
                $request->get('endDate'),
                intval($request->get('parameterTypeId')),
                intval($request->get('parameter')),
                $request->get('acrissIds'),
                $request->get('replacementAcrissIds'),
                $request->get('regionIds'),
                $request->get('areaIds'),
                $request->get('branchIds'),
                $request->get('partnerIds'),
                $request->get('startTime'),
                $request->get('endTime'),
                boolval($request->get('connectedVehicle')),
                filter_var($request->get('isOverride', false), FILTER_VALIDATE_BOOLEAN)
    
            );
    
            $response = $handler->handle($command);
    
            return $this->json(['id' => $response->getId()]);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);

        }
    }

    public function show(): Response
    {
        // Se ha quitado el acceso en el menú y en el route. Tarea P28-699
        return $this->render('pages/parameter_settings/show.html.twig');
    }

      /**
     * @param Request $request
     * @param DeleteParameterSettingCommandHandler $handler
     * @return RedirectResponse
     */
    public function delete(Request $request, DeleteParameterSettingCommandHandler $handler): Response
    {
        try {
            
            $command = new DeleteParameterSettingCommand(intval($request->get('id')));
            $response = $handler->handle($command);
            return $this->json(['deleted' => $response->isDeleted()]);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
