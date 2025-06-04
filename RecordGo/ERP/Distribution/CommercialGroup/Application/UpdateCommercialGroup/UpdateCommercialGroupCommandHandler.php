<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\UpdateCommercialGroup;

use Exception;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\CommercialGroup\Domain\Acriss;
use Distribution\CommercialGroup\Domain\Translation;
use Distribution\CommercialGroup\Domain\CommercialGroup;
use Distribution\CommercialGroup\Domain\AcrissCollection;
use Distribution\CommercialGroup\Domain\TranslationCollection;
use Distribution\CommercialGroup\Domain\CommercialGroupCriteria;
use Distribution\CommercialGroup\Domain\CommercialGroupRepository;

class UpdateCommercialGroupCommandHandler
{
    /**
     * @var CommercialGroupRepository
     */
    private CommercialGroupRepository $commercialGroupRepository;

    public function __construct(CommercialGroupRepository $commercialGroupRepository)
    {

        $this->commercialGroupRepository = $commercialGroupRepository;
    }

    final public function handle(UpdateCommercialGroupCommand $command): UpdateCommercialGroupResponse
    {
        $response = null;
        $nameExists = false;

        /**
         * @var CommercialGroup $commercialGroup
         */
        $commercialGroup = $this->commercialGroupRepository->getById($command->getCommercialGroup()['id']);

        if ($commercialGroup->getName() != $command->getCommercialGroup()['name']) {
            $filterCollection = new FilterCollection([]);
            $filterCollection->add(new Filter('GROUPNAME', new FilterOperator(FilterOperator::EQUAL), $command->getCommercialGroup()['name']));
            $getByResponse = $this->commercialGroupRepository->getBy(new CommercialGroupCriteria($filterCollection));

            //FIXME igual es mejor añadir el filtro al getBy
            // $nameExists = $getByResponse->getCollection()->count() > 0;

            try {
                $nameExists = $getByResponse->getCollection()->getByProperty($command->getCommercialGroup()['name'], 'name') ? true : false;
            } catch (Exception $e) {
                $nameExists = false;
            }
        }

        if (!$nameExists) {
            $commercialGroup->setName($command->getCommercialGroup()['name']);

            $acrissCollection = new AcrissCollection([]);
            foreach ($command->getCommercialGroup()['acrissIds'] as $acrissId) {
                $acrissCollection->add(new Acriss(intval($acrissId)));
            }
            $commercialGroup->setAcriss($acrissCollection);

            $translationCollection = new TranslationCollection([]);
            foreach ($command->getCommercialGroup()['translations'] as $translation) {
                $translationCollection->add(new Translation(
                    null,
                    $translation['translation'],
                    $translation['languageId'],
                    $translation['default']
                ));
            }
            $commercialGroup->setTranslations($translationCollection);

            $commercialGroup->setActive($command->getCommercialGroup()['status']);

            $response = $this->commercialGroupRepository->update($commercialGroup);
        }

        return new UpdateCommercialGroupResponse(($response ? true : false), $nameExists);
    }
}
