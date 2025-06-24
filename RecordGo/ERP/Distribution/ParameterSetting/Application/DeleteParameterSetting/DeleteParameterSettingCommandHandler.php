<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Application\DeleteParameterSetting;

use Distribution\ParameterSetting\Domain\ParameterSettingRepository;

/**
 * Class DeleteParameterSettingCommandHandler
 *
 * Handles the deletion of parameter settings.
 */

class DeleteParameterSettingCommandHandler
{
    /**
     * @var ParameterSettingRepository
     */
    private ParameterSettingRepository $parameterSettingRepository;

    /**
     * DeleteParameterSettingCommandHandler constructor.
     *
     * @param ParameterSettingRepository $parameterSettingRepository
     */
    public function __construct(ParameterSettingRepository $parameterSettingRepository)
    {
        $this->parameterSettingRepository = $parameterSettingRepository;
    }

    /**
     * Handle the deletion command.
     *
     * @param DeleteParameterSettingCommand $command
     * @return DeleteParameterSettingCommandResponse
     */
    public function handle(DeleteParameterSettingCommand $command): DeleteParameterSettingCommandResponse
    {
        $response = $this->parameterSettingRepository->delete($command->getId());
        return new DeleteParameterSettingCommandResponse($response->getOperationResponse()->wasSuccess());
    }
}
