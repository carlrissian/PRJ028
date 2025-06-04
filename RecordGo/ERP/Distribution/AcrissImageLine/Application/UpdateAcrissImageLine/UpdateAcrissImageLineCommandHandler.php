<?php

declare(strict_types=1);

namespace Distribution\AcrissImageLine\Application\UpdateAcrissImageLine;

use Distribution\AcrissImageLine\Domain\AcrissImageLine;
use Distribution\AcrissImageLine\Domain\AcrissImageLineRepository;

class UpdateAcrissImageLineCommandHandler
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

    public function handle(UpdateAcrissImageLineCommand $command): UpdateAcrissImageLineResponse
    {
        $acrissImageLine = new AcrissImageLine(
            $command->getId(),
            $command->getAcrissId(),
            $command->getBranchId(),
            $command->getUrl(),
            $command->getDescription(),
            $command->isByDefault()
        );

        $response = $this->acrissImageLineRepository->store($acrissImageLine);

        return new UpdateAcrissImageLineResponse('success', 'Actualizada correctamente la línea de imágen ' . $response);
    }
}
