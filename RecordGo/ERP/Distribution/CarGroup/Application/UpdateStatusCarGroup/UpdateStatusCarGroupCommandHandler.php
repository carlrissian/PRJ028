<?php
declare(strict_types=1);


namespace Distribution\CarGroup\Application\UpdateStatusCarGroup;


use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\Shared\Domain\RepositoryException;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;


/**
 * Class StoreAcrissCommandHandler
 * @package Distribution\Acriss\Application\StoreAcriss
 */
class UpdateStatusCarGroupCommandHandler
{
    /**
     * @var CarGroupRepository
     */
    private CarGroupRepository $carGroupRepository;
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * @param CarGroupRepository $carGroupRepository
     * @param AcrissRepository $acrissRepository
     */
    public function __construct(CarGroupRepository $carGroupRepository, AcrissRepository $acrissRepository)
    {
        $this->carGroupRepository = $carGroupRepository;
        $this->acrissRepository = $acrissRepository;
    }

    /**
     * @param UpdateStatusCarGroupCommand $command
     * @return UpdateStatusCarGroupResponse
     * @throws RepositoryException
     */
    public function handle(UpdateStatusCarGroupCommand $command): UpdateStatusCarGroupResponse
    {
        $carGroupId = $command->getCarGroupId();
        $status = $command->isEnabled();
        $statusText = $status ? 'ACTIVADO' : 'DESACTIVADO';

        $carGroupToUpdate = $this->carGroupRepository->getById($carGroupId);

        $acrissFilterCollection = new FilterCollection([]);

        $acrissResponse = $this->acrissRepository->getBy(new AcrissCriteria($acrissFilterCollection));

        $acrissFiltered = array_filter($acrissResponse->getCollection()->toArray(), function ($acriss) use ($carGroupId){
            return $acriss->getCarGroup() && $acriss->getCarGroup()->getId() == $carGroupId;
        });
        $acriss = array_shift($acrissFiltered);

        $acrissCriteria = new AcrissCriteria(new FilterCollection([new Filter('ID', new FilterOperator(FilterOperator::EQUAL), $acriss->getId())]));
        $isOnBooking = $this->acrissRepository->checkIsOnBooking($acrissCriteria);

        if($isOnBooking){
            $statusResponse= 'error';
            $message = 'No se puede editar el estado del Grupo flota '.$carGroupToUpdate->getName().'. ACRISS En reserva o contrato';
            return new UpdateStatusCarGroupResponse($statusResponse, $message);
        }

        $carGroupToUpdate->setEnabled($status);

        $carGroupResonse = $this->carGroupRepository->update($carGroupToUpdate);
        $statusResponse = 'success';
        $message = 'Grupo flota ' .$carGroupToUpdate->getName(). ' ' .$statusText. ' correctamente';
        return new UpdateStatusCarGroupResponse($statusResponse, $message);
    }
}
