<?php

declare(strict_types=1);

namespace Distribution\AcrissImageLine\Application\StoreAcrissImageLine;

use Distribution\AcrissImageLine\Domain\AcrissImageLine;
use Distribution\AcrissImageLine\Domain\AcrissImageLineRepository;

class StoreAcrissImageLineCommandHandler
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

    public function handle(StoreAcrissImageLineCommand $command): StoreAcrissImageLineResponse
    {
        $acrissImageLine = new AcrissImageLine(
            null,
            $command->getAcrissId(),
            $command->getBranchId(),
            $command->getUrl(),
            $command->getDescription(),
            $command->isByDefault()
        );

        $response = $this->acrissImageLineRepository->store($acrissImageLine);

        return new StoreAcrissImageLineResponse('success', 'Creada correctamente linea de imágen ' . $response, $response);
    }
}
