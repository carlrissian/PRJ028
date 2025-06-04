<?php
declare(strict_types=1);


namespace Distribution\CarGroup\Application\UpdateCarGroup;

use Distribution\CarGroup\Domain\CarGroup;
use Distribution\CarGroup\Domain\CarGroupCriteria;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\Shared\Domain\RepositoryException;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

/**
 * Class EditCarGroupCommandHandler
 * @package Distribution\CarGroup\Application\EditCarGroup
 */
class UpdateCarGroupCommandHandler
{
    /**
     * @var CarGroupRepository
     */
    private CarGroupRepository $groupRepository;

    /**
     * StoreCarGroupCommandHandler constructor.
     * @param CarGroupRepository $groupRepository
     */
    public function __construct(CarGroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * @param UpdateCarGroupCommand $command
     * @return UpdateCarGroupResponse
     * @throws RepositoryException
     */
    public function handle(UpdateCarGroupCommand $command): UpdateCarGroupResponse
    {
        if($command->getName() === ''){
            throw new RepositoryException();
        }

        // Comprobar en repositorio si existe antes de guardar
        $carGroupFilterCollection = new FilterCollection([]);
        $carGroupFilterCollection->add(new Filter('VEHICLEGROUPNAME', new FilterOperator(FilterOperator::EQUAL), $command->getName()));
        $carGroupCriteria= new CarGroupCriteria($carGroupFilterCollection);
        $response = $this->groupRepository->getBy($carGroupCriteria);

        //Error si existe en repositorio Grupo flota con mismo nombre
        if($response->getTotalRows()>0){
            throw new RepositoryException('Existe Grupo flota con nombre ' .$command->getName());
        }

        $carGroup = $this->groupRepository->getById($command->getId());
        if(is_null($carGroup)){
            throw new RepositoryException('No existe Grupo flota con id ' .$command->getId());
        }

        $groupToUpdate = new CarGroup($command->getId(), $command->getName(), $carGroup->isEnabled());
        $group = $this->groupRepository->update($groupToUpdate);

        if(is_null($group)){
            throw new RepositoryException();
        }

        return new UpdateCarGroupResponse();
    }
}