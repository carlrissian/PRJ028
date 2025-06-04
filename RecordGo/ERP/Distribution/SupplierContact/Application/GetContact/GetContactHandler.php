<?php
declare(strict_types=1);


namespace Distribution\SupplierContact\Application\GetContact;

use Distribution\SupplierContact\Domain\SupplierContactCriteria;
use Distribution\SupplierContact\Domain\SupplierContactRepositoryInterface;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Pagination\Pagination;

class GetContactHandler
{
    /**
     * @var SupplierContactRepositoryInterface
     */
    private SupplierContactRepositoryInterface $contactRepository;

    /**
     * GetContactHandler constructor.
     * @param SupplierContactRepositoryInterface $contactRepository
     */
    public function __construct(SupplierContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    final public function handle(GetContactQuery $query): GetContactResponse
    {
        $filter = new FilterCollection([new Filter('PROVIDERID', new FilterOperator(FilterOperator::EQUAL), //'supplierCode'
            $query->getCode())]);
        $response = $this->contactRepository->getBy(new SupplierContactCriteria($filter, new Pagination(100, 0)));

        return new GetContactResponse($response->getCollection(), $response->getTotalRows());
    }
}