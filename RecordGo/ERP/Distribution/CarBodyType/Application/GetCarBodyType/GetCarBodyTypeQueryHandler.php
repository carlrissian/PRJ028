<?php
declare(strict_types=1);


namespace Distribution\CarBodyType\Application\GetCarBodyType;


use Distribution\CarBodyType\Domain\CarBodyTypeCollection;
use Distribution\CarBodyType\Domain\CarBodyTypeCriteria;
use Distribution\CarBodyType\Domain\CarBodyTypeRepository;

/**
 * Class GetCarBodyTypeQueryHandler
 * @package Distribution\CarBodyType\Application\GetCarBodyType
 */
class GetCarBodyTypeQueryHandler
{
    /**
     * @var CarBodyTypeRepository
     */
    private CarBodyTypeRepository $carBodyTypeRepository;


    /**
     * GetCarBodyTypeHandler constructor.
     * @param CarBodyTypeRepository $carBodyTypeRepository
     */
    public function __construct(CarBodyTypeRepository $carBodyTypeRepository)
    {
        $this->carBodyTypeRepository = $carBodyTypeRepository;
    }

    /**
     * @param GetCarBodyTypeQuery $bodyworkQuery
     * @return GetCarBodyTypeQueryHandlerResponse
     */
    public function handler(GetCarBodyTypeQuery $bodyworkQuery): GetCarBodyTypeQueryHandlerResponse
    {
        $response = $this->carBodyTypeRepository->getBy(new CarBodyTypeCriteria());

        return new GetCarBodyTypeQueryHandlerResponse(new CarBodyTypeCollection($response->getData()), $response->getTotalRows());
    }
}