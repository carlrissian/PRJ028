<?php
declare(strict_types=1);

namespace Distribution\CommercialGroupTranslations\Application\DeleteCommercialGroupTranslations;

use Distribution\CommercialGroupTranslations\Domain\CommercialGroupTranslationsRepository;

class DeleteCommercialGroupTranslationsCommandHandler
{

    /**
     * @var CommercialGroupTranslationsRepository
     */
    private CommercialGroupTranslationsRepository $commercialGrouptranslationsRepository;
    
    public function __construct(CommercialGroupTranslationsRepository $commercialGrouptranslationsRepository){

        $this->commercialGrouptranslationsRepository = $commercialGrouptranslationsRepository;
    }

    public function handle(DeleteCommercialGroupTranslationsCommand $command): DeleteCommercialGroupTranslationsResponse{

        $id = $command->getId();
        $commercialGrouptranslations = $this->commercialGrouptranslationsRepository->delete($id);

        return new DeleteCommercialGroupTranslationsResponse('success', 'Traduccion borrada correctamente');
    }
}