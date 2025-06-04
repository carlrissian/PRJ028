<?php

namespace Distribution\Brand\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\Brand\Domain\BrandCriteria;
use Distribution\Brand\Domain\BrandRepository;

class SelectListBrandQueryHandler
{
    /**
     * @var BrandRepository
     */
    private $brandRepository;

    /**
     * SelectListBrandQueryHandler constructor.
     *
     * @param BrandRepository $brandRepository
     */
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * @return SelectListBrandResponse
     */
    public function handle(): SelectListBrandResponse
    {
        $brandCollection = $this->brandRepository->getBy(new BrandCriteria())->getCollection();
        return new SelectListBrandResponse(Utils::createSelect($brandCollection));
    }
}
