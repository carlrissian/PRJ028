<?php
declare(strict_types=1);

namespace Distribution\CommercialGroupTranslations\Application\StoreCommercialGroupTranslations;

use Distribution\CommercialGroupTranslations\Domain\CommercialGroupTranslationsRepository;
use Distribution\CommercialGroupTranslations\Domain\Translation;

class StoreCommercialGroupTranslationsCommandHandler
{

    /**
     * @var CommercialGroupTranslationsRepository
     */
    private CommercialGroupTranslationsRepository $commercialGrouptranslationsRepository;

    public function __construct(CommercialGroupTranslationsRepository $commercialGrouptranslationsRepository){

        $this->commercialGrouptranslationsRepository = $commercialGrouptranslationsRepository;
    }

    public function handle(StoreCommercialGroupTranslationsCommand $command): StoreCommercialGroupTranslationsResponse{

        $translationToStore = new Translation(null, $command->getCommercialGroupId(), $command->getLanguageId(), $command->getLanguageCode(), $command->getTranslation(), $command->isDefault(), null, $command->getUserId());

        $translation = $this->commercialGrouptranslationsRepository->store($translationToStore);

        return new StoreCommercialGroupTranslationsResponse('success', 'Traduccion creada correctamente '.$translation->getLanguageCode(), $translation->getId());
    }
}