<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Application\UpdateAcrissBranch;

use Distribution\AcrissBranchTranslations\Domain\Branch;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepositoryInterface;

class UpdateAcrissBranchCommandHandler
{
    /**
     * @var AcrissBranchTranslationsRepositoryInterface
     */
    private AcrissBranchTranslationsRepositoryInterface $acrissBranchTranslationsRepository;

    /**
     * constructor.
     *
     * @param AcrissBranchTranslationsRepositoryInterface $acrissBranchTranslationsRepository
     */
    public function __construct(AcrissBranchTranslationsRepositoryInterface $acrissBranchTranslationsRepository)
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

        $translation = AcrissBranchTranslation::create(
            null,
            Branch::create($command->getBranchId()),
            $command->isByDefault()
        );

        $response = $this->acrissBranchTranslationsRepository->update($translation);

        return new UpdateAcrissBranchResponse('success', 'Actualizado correctamente ' . $response);
    }
}
