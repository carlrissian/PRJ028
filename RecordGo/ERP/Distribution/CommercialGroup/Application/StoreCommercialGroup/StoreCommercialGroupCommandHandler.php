<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\StoreCommercialGroup;

use Exception;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\CommercialGroup\Domain\Acriss;
use Distribution\Shared\Domain\RepositoryException;
use Distribution\CommercialGroup\Domain\CommercialGroup;
use Distribution\CommercialGroup\Domain\AcrissCollection;
use Distribution\CommercialGroup\Domain\CommercialGroupCriteria;
use Distribution\CommercialGroup\Domain\CommercialGroupRepository;

class StoreCommercialGroupCommandHandler
{
    /**
     * @var CommercialGroupRepository
     */
    private CommercialGroupRepository $commercialGroupRepository;

    /**
     * StoreCommercialGroupCommandHandler constructor.
     *
     * @param CommercialGroupRepository $commercialGroupRepository
     */
    public function __construct(CommercialGroupRepository $commercialGroupRepository)
    {
        $this->commercialGroupRepository = $commercialGroupRepository;
    }

    /**
     * @throws RepositoryException
     */
    public function handle(StoreCommercialGroupCommand $command): StoreCommercialGroupResponse
    {
        $response = null;
        $nameExists = false;

        $filterCollection = new FilterCollection([]);
        $filterCollection->add(new Filter('GROUPNAME', new FilterOperator(FilterOperator::EQUAL), $command->getName()));
        $getByResponse = $this->commercialGroupRepository->getBy(new CommercialGroupCriteria($filterCollection));

        //FIXME igual es mejor añadir el filtro al getBy
        // $nameExists = $getByResponse->getCollection()->count() > 0;

        try {
            $nameExists = $getByResponse->getCollection()->getByProperty($command->getName(), 'name') ? true : false;
        } catch (Exception $e) {
            $nameExists = false;
        }


        if (!$nameExists) {
            $acrissCollection = new AcrissCollection([]);
            foreach ($command->getAcrissIds() as $acrissId) {
                $acrissCollection->add(new Acriss(intval($acrissId)));
            }

            $commercialGroup = new CommercialGroup(
                null,
                $command->getName(),
                $acrissCollection,
                null,
                $command->isActive() ?? true
            );

            $response = $this->commercialGroupRepository->store($commercialGroup);
        }

        return new StoreCommercialGroupResponse(($response ? true : false), $nameExists);
    }
}
