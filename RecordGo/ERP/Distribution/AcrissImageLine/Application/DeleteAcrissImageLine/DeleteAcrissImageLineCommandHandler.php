<?php

declare(strict_types=1);

namespace Distribution\AcrissImageLine\Application\DeleteAcrissImageLine;

use Distribution\AcrissImageLine\Domain\AcrissImageLineRepository;

class DeleteAcrissImageLineCommandHandler
{
    /**
     * @var AcrissImageLineRepository
     */
    private AcrissImageLineRepository $acrissImageLineRepository;

    /**
     * constructor
     *
     * @param AcrissImageLineRepository $acrissImageLineRepository
     */
    public function __construct(AcrissImageLineRepository $acrissImageLineRepository)
    {
        $this->acrissImageLineRepository = $acrissImageLineRepository;
    }

    public function handle(DeleteAcrissImageLineCommand $command): DeleteAcrissImageLineResponse
    {
        $response = $this->acrissImageLineRepository->delete($command->getId());

        // TODO mejorar lógica response
        return new DeleteAcrissImageLineResponse('success', 'Borrado correctamente');
    }
}
