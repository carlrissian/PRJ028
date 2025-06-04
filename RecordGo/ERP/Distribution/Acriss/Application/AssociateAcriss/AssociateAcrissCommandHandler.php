<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\AssociateAcriss;


use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissInferior;
use Distribution\Acriss\Domain\AcrissInferiorCollection;
use Distribution\Acriss\Domain\AcrissRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

class AssociateAcrissCommandHandler
{
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * GetAcrissHandler constructor.
     * @param AcrissRepository $acrissRepository
     */
    public function __construct(AcrissRepository $acrissRepository)
    {
        $this->acrissRepository = $acrissRepository;
    }

    public function handle(AssociateAcrissCommand $associateAcrissCommand): AssociateAcrissResponse
    {
        $acriss = $this->acrissRepository->getById($associateAcrissCommand->getAcrissId());

        if($acriss->getName() == 'R'){
            $parentId = $acriss->getId();

            $acrissResponse = $this->acrissRepository->getBy(new AcrissCriteria(new FilterCollection([new Filter('id', new FilterOperator(FilterOperator::IN), $associateAcrissCommand->getAcrissList())])));
            $acrissInferiorCollection = new AcrissInferiorCollection([]);
            foreach ($acrissResponse->getCollection() as $acrissToAssociate){
                if($acrissToAssociate->getCarGroup()){
                    $acriss->setCarGroup($acrissToAssociate->getCarGroup());
                }
                $acrissToAssociate->setAcrissParentId($parentId);
                $this->acrissRepository->update($acrissToAssociate);
                $acrissInferiorCollection->add(new AcrissInferior($acrissToAssociate->getId(), $acrissToAssociate->getAcrissName()->__toString()));
            }
            $acriss->setAcrissInferiorCollection($acrissInferiorCollection);

        }else{
            $parentId = $associateAcrissCommand->getAcrissList()[0];
            $acriss->setAcrissParentId($parentId);
        }
        $this->acrissRepository->update($acriss);

        return new AssociateAcrissResponse();
    }
}