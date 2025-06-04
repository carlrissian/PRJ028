<?php
declare(strict_types=1);


namespace Distribution\CarGroup\Application\StoreCarGroup;

use DateTime;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\CarGroup\Domain\CarGroup;
use Distribution\CarGroup\Domain\CarGroupCriteria;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\Shared\Domain\RepositoryException;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

/**
 * Class StoreCarGroupCommandHandler
 * @package Distribution\CarGroup\Application\StoreCarGroup
 */
class StoreCarGroupCommandHandler
{
    /**
     * @var CarGroupRepository
     */
    private CarGroupRepository $groupRepository;
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * @param CarGroupRepository $groupRepository
     * @param AcrissRepository $acrissRepository
     */
    public function __construct(CarGroupRepository $groupRepository, AcrissRepository $acrissRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->acrissRepository = $acrissRepository;
    }

    /**
     * @param StoreCarGroupCommand $command
     * @return StoreCarGroupCommandResponse
     * @throws RepositoryException
     */
    public function handle(StoreCarGroupCommand $command): StoreCarGroupCommandResponse
    {
        // Comprobar en repositorio si existe antes de guardar
        $carGroupFilterCollection = new FilterCollection([]);
        $carGroupFilterCollection->add(new Filter('VEHICLEGROUPNAME', new FilterOperator(FilterOperator::EQUAL), $command->getName()));
        $carGroupCriteria= new CarGroupCriteria($carGroupFilterCollection);
        $response = $this->groupRepository->getBy($carGroupCriteria);

        if($response->getTotalRows()>0){
            throw new RepositoryException('Existe Grupo flota con nombre ' .$command->getName());
        }

        //Guardar si no existe en repositorio
        if($response->getTotalRows()==0){

            $acriss = $this->acrissRepository->getById($command->getAcrissId());

            // Crear nuevo VehicleGroup con estado igual al del ACRISS
            $groupToStore = new CarGroup(
                null,
                $command->getName(),
                $acriss->isEnabled()
            );

            $groupId = $this->groupRepository->store($groupToStore);

            $acriss->setCarGroup(new \Distribution\Acriss\Domain\CarGroup($groupId));
            $this->acrissRepository->update($acriss);
        }

        return new StoreCarGroupCommandResponse();
    }
}