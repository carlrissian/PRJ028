<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Application\StoreAcrissBranch;

use Distribution\AcrissBranchTranslations\Domain\Branch;
use Distribution\AcrissBranchTranslations\Domain\BranchTranslations;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepository;

class StoreAcrissBranchCommandHandler
{
    /**
     * @var AcrissBranchTranslationsRepository
     */
    private AcrissBranchTranslationsRepository $acrissBranchTranslationsRepository;

    /**
     * constructor
     *
     * @param AcrissBranchTranslationsRepository $acrissBranchTranslationsRepository
     */
    public function __construct(AcrissBranchTranslationsRepository $acrissBranchTranslationsRepository)
    {
        $this->acrissBranchTranslationsRepository = $acrissBranchTranslationsRepository;
    }

    /**
     * @param StoreAcrissBranchCommand $command
     * @return StoreAcrissBranchResponse
     */
    final public function handle(StoreAcrissBranchCommand $command): StoreAcrissBranchResponse
    {
        // FIXME corregir lógica y datos a recibir en command
        $creationUserId = $command->getUserId();
        $branchId = $command->getBranchId();
        $acrissId = $command->getAcrissId();
        $default = $command->isByDefault();
        $commercialName = $command->getCommercialName();

        // $branch = new BranchTranslations(null, $acrissId, new Branch($branchId), $commercialName, $default, null, $creationUserId);

        $translation = new AcrissBranchTranslation(
            null,
            new Branch($command->getBranchId()),
            $command->isByDefault()
        );

        $response = $this->acrissBranchTranslationsRepository->store($translation);

        return new StoreAcrissBranchResponse('success', 'Guardado correctamente', $response);
    }
}
