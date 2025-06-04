<?php

declare(strict_types=1);

namespace Distribution\AcrissTranslations\Application\DeleteAcrissTranslations;

use Distribution\AcrissTranslations\Domain\AcrissTranslationsRepository;

class DeleteAcrissTranslationsCommandHandler
{
    /**
     * @var AcrissTranslationsRepository
     */
    private AcrissTranslationsRepository $acrisstranslationsRepository;

    public function __construct(AcrissTranslationsRepository $acrisstranslationsRepository)
    {
        $this->acrisstranslationsRepository = $acrisstranslationsRepository;
    }

    public function handle(DeleteAcrissTranslationsCommand $command): DeleteAcrissTranslationsResponse
    {
        $response = $this->acrisstranslationsRepository->delete($command->getId());

        // TODO gestionar bien el response
        return new DeleteAcrissTranslationsResponse('success', 'Traduccion borrada correctamente');
    }
}
