<?php

declare(strict_types=1);

namespace Distribution\AcrissTranslations\Application\StoreAcrissTranslations;

use Distribution\AcrissTranslations\Domain\User;
use Distribution\AcrissTranslations\Domain\AcrissTranslation;
use Distribution\AcrissTranslations\Domain\AcrissTranslationsRepository;

class StoreAcrissTranslationsCommandHandler
{
    /**
     * @var AcrissTranslationsRepository
     */
    private AcrissTranslationsRepository $acrisstranslationsRepository;

    /**
     * contructor.
     * 
     * @param AcrissTranslationsRepository $acrisstranslationsRepository
     */
    public function __construct(AcrissTranslationsRepository $acrisstranslationsRepository)
    {
        $this->acrisstranslationsRepository = $acrisstranslationsRepository;
    }

    /**
     * @param StoreAcrissTranslationsCommand $command
     * @return StoreAcrissTranslationsResponse
     */
    public function handle(StoreAcrissTranslationsCommand $command): StoreAcrissTranslationsResponse
    {
        $translation = new AcrissTranslation(
            null,
            $command->getAcrissId(),
            $command->getBranchId(),
            $command->getLanguageId(),
            $command->getLanguageCode(),
            $command->getTranslation(),
            $command->isDefault(),
            null,
            ($command->getUserId()) ? new User($command->getUserId()) : null
        );

        $response = $this->acrisstranslationsRepository->store($translation);

        return new StoreAcrissTranslationsResponse('success', 'Traduccion creada correctamente ' . $response, $response);
    }
}
