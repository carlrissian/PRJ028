<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Application\DeleteAcrissBranch;

use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepository;

class DeleteAcrissBranchCommandHandler
{
    /**
     * @var AcrissBranchTranslationsRepository
     */
    private AcrissBranchTranslationsRepository $acrissBranchTranslationsRepository;

    /**
     * constructor.
     *
     * @param AcrissBranchTranslationsRepository $acrissBranchTranslationsRepository
     */
    public function __construct(AcrissBranchTranslationsRepository $acrissBranchTranslationsRepository)
    {

        $this->acrissBranchTranslationsRepository = $acrissBranchTranslationsRepository;
    }

    /**
     * @param DeleteAcrissBranchCommand $command
     * @return DeleteAcrissBranchResponse
     */
    public function handle(DeleteAcrissBranchCommand $command): DeleteAcrissBranchResponse
    {
        $response = $this->acrissBranchTranslationsRepository->delete($command->getId());

        //TODO mejorar lógica response
        return new DeleteAcrissBranchResponse('success', 'Borrado correctamente');
    }
}
