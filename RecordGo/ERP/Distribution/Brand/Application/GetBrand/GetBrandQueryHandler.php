<?php
declare(strict_types=1);

namespace Distribution\Brand\Application\GetBrand;

use Distribution\Brand\Domain\BrandCriteria;
use Distribution\Brand\Domain\BrandRepository;

/**
 * Class GetBrandQueryHandler
 * @package Distribution\Brand\Application\GetBrand
 */
class GetBrandQueryHandler
{
    /**
     * @var BrandRepository
     */
    private BrandRepository $brandRepository;

    /**
     * GetBrandHandler constructor.
     * @param BrandRepository $brandRepository
     */
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * @param GetBrandQuery $getBrandQuery
     * @return GetBrandQueryHandlerResponse
     */
    final public function handle(GetBrandQuery $getBrandQuery): GetBrandQueryHandlerResponse
    {
        $response =  $this->brandRepository->getBy(new BrandCriteria());

        return new GetBrandQueryHandlerResponse($response->getCollection(), $response->getTotalRows());
    }
}