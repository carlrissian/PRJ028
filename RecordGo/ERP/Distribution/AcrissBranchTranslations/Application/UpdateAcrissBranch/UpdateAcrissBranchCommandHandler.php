<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Application\UpdateAcrissBranch;

use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepository;
use Distribution\AcrissBranchTranslations\Domain\Branch;

class UpdateAcrissBranchCommandHandler
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

    public function handle(UpdateAcrissBranchCommand $command): UpdateAcrissBranchResponse
    {
        // FIXME corregir lógica y datos a recibir en command

        $id = $command->getId();
        $acrissId = $command->getAcrissId();
        $branchId = $command->getBranchId();
        $commercialName = $command->getCommercialName();
        $default = $command->isByDefault();
        $userId = $command->getUserId();

        $translation = new AcrissBranchTranslation(
            null,
            new Branch($command->getBranchId()),
            $command->isByDefault()
        );

        $response = $this->acrissBranchTranslationsRepository->update($translation);

        return new UpdateAcrissBranchResponse('success', 'Actualizado correctamente ' . $response);
    }
}
