<?php
declare(strict_types=1);


namespace Distribution\Area\Application\GetArea;


use Distribution\Area\Domain\AreaCollection;
use Distribution\Area\Domain\AreaCriteria;
use Distribution\Area\Domain\AreaRepository;

class GetAreaQueryHandler
{
    /**
     * @var AreaRepository
     */
    private AreaRepository $areaRepository;

    /**
     * GetAreaHandler constructor.
     * @param AreaRepository $areaRepository
     */
    public function __construct(AreaRepository $areaRepository)
    {
        $this->areaRepository = $areaRepository;
    }

    public function handle(GetAreaQuery $query): GetAreaQueryHandlerResponse
    {
        $response = $this->areaRepository->getBy(new AreaCriteria());

        return new GetAreaQueryHandlerResponse(new AreaCollection($response->getData()), $response->getTotalRows());
    }
}