<?php

namespace Distribution\Supplier\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\Supplier\Domain\SupplierCriteria;
use Distribution\Supplier\Domain\SupplierRepository;

class SelectListSupplierQueryHandler
{
    /**
     * @var SupplierRepository
     */
    private $supplierRepository;

    /**
     * SelectListSupplierQueryHandler constructor.
     *
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * @return SelectListSupplierResponse
     */
    public function handle(): SelectListSupplierResponse
    {
        $supplierCollection = $this->supplierRepository->getBy(new SupplierCriteria())->getCollection();
        return new SelectListSupplierResponse(Utils::createSelect($supplierCollection));
    }
}
