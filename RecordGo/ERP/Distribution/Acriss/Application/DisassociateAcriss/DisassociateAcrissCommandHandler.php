<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\DisassociateAcriss;


use Distribution\Acriss\Domain\AcrissRepository;

class DisassociateAcrissCommandHandler
{
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * DisassociateAcrissHandler constructor.
     * @param AcrissRepository $acrissRepository
     */
    public function __construct(AcrissRepository $acrissRepository)
    {
        $this->acrissRepository = $acrissRepository;
    }

    public function handle(DisassociateAcrissCommand $disasssociateAcrissCommand): DisassociateAcrissResponse
    {
        $acriss = $this->acrissRepository->getById($disasssociateAcrissCommand->getAcrissId());
        $acrissToDisassociate = $disasssociateAcrissCommand->getAcrissList();

        $acrissChilds = $acriss->getAcrissInferiorCollection();

        foreach($acrissToDisassociate as $acrissId){
            $acrissChilds->removeByProperty($acrissId, 'id');

            $acrissChildToDisassociate = $this->acrissRepository->getById($acrissId);
            $acrissChildToDisassociate->setAcrissParentId(null);
            $this->acrissRepository->update($acrissChildToDisassociate);
        }

        $acriss->setAcrissInferiorCollection($acrissChilds);
        $this->acrissRepository->update($acriss);

        return new DisassociateAcrissResponse();
    }
}