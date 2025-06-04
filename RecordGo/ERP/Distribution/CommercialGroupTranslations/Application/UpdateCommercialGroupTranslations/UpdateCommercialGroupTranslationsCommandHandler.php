<?php
declare(strict_types=1);

namespace Distribution\CommercialGroupTranslations\Application\UpdateCommercialGroupTranslations;


use Distribution\CommercialGroupTranslations\Domain\CommercialGroupTranslationsRepository;
use Distribution\CommercialGroupTranslations\Domain\Translation;

class UpdateCommercialGroupTranslationsCommandHandler
{

    /**
     * @var CommercialGroupTranslationsRepository
     */
    private CommercialGroupTranslationsRepository $commercialGrouptranslationsRepository;
    
    public function __construct(CommercialGroupTranslationsRepository $commercialGrouptranslationsRepository){

        $this->commercialGrouptranslationsRepository = $commercialGrouptranslationsRepository;
    }

    public function handle(UpdateCommercialGroupTranslationsCommand $command): UpdateCommercialGroupTranslationsResponse{

        $translationToUpdate = new Translation($command->getId(), $command->getCommercialGroupId(), $command->getLanguageId(), $command->getLanguageCode(), $command->getTranslation(), $command->isDefault(), null, null, null, $command->getUserId());
        $translation = $this->commercialGrouptranslationsRepository->update($translationToUpdate);

        return new UpdateCommercialGroupTranslationsResponse('success', 'Traduccion actualizada '.$translation->getLanguageCode());
    }
}