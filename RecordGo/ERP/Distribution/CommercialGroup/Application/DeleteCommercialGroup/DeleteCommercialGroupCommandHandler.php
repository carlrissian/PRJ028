<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\DeleteCommercialGroup;

use Distribution\CommercialGroup\Domain\CommercialGroupRepository;

/**
 * Class DeleteCommercialGroupCommandHandler
 * @package Distribution\CommercialGroup\Application\DeleteCommercialGroup
 */
class DeleteCommercialGroupCommandHandler
{
    /**
     * @var CommercialGroupRepository
     */
    private CommercialGroupRepository $commercialGroupRepository;

    /**
     * DeleteCommercialGroupCommandHandler constructor.
     * 
     * @param CommercialGroupRepository $commercialGroupRepository
     */
    public function __construct(CommercialGroupRepository $commercialGroupRepository)
    {
        $this->commercialGroupRepository = $commercialGroupRepository;
    }

    /**
     * @param DeleteCommercialGroupCommand $command
     * @return DeleteCommercialGroupCommandResponse
     * @throws RepositoryException
     */
    public function handle(DeleteCommercialGroupCommand $command): DeleteCommercialGroupCommandResponse
    {
        $response = $this->commercialGroupRepository->delete($command->getId());

        return new DeleteCommercialGroupCommandResponse($response);
    }
}
