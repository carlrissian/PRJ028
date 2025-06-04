<?php

declare(strict_types=1);

namespace Distribution\AcrissTranslations\Application\UpdateAcrissTranslations;

use Distribution\AcrissTranslations\Domain\User;
use Distribution\AcrissTranslations\Domain\AcrissTranslation;
use Distribution\AcrissTranslations\Domain\AcrissTranslationsRepository;

class UpdateAcrissTranslationsCommandHandler
{
    /**
     * @var AcrissTranslationsRepository
     */
    private AcrissTranslationsRepository $acrisstranslationsRepository;

    /**
     * constructor.
     *
     * @param AcrissTranslationsRepository $acrisstranslationsRepository
     */
    public function __construct(AcrissTranslationsRepository $acrisstranslationsRepository)
    {
        $this->acrisstranslationsRepository = $acrisstranslationsRepository;
    }

    /**
     * @param UpdateAcrissTranslationsCommand $command
     * @return UpdateAcrissTranslationsResponse
     */
    public function handle(UpdateAcrissTranslationsCommand $command): UpdateAcrissTranslationsResponse
    {
        $translation = new AcrissTranslation(
            $command->getId(),
            $command->getAcrissId(),
            $command->getBranchId(),
            $command->getLanguageId(),
            $command->getLanguageCode(),
            $command->getTranslation(),
            $command->isDefault(),
            null,
            null,
            null,
            ($command->getUserId()) ? new User($command->getUserId()) : null
        );

        $response = $this->acrisstranslationsRepository->update($translation);

        return new UpdateAcrissTranslationsResponse('success', 'Traduccion actualizada ' . $response);
    }
}
