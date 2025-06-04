<?php

namespace Distribution\TransportDriver\Application\FilterTransportDriver;

use Exception;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\Supplier\Domain\SupplierCriteria;
use Distribution\Supplier\Domain\SupplierRepository;
use Distribution\TransportDriver\Domain\TransportDriver;
use Distribution\TransportDriver\Domain\TransportDriverCriteria;
use Distribution\TransportDriver\Domain\TransportDriverRepository;

class FilterTransportDriverQueyHandler
{
    /**
     * @var TransportDriverRepository
     */
    private $transportDriverRepository;

    /**
     * @var SupplierRepository
     */
    private $supplierRepository;

    /**
     * constructor.
     *
     * @param TransportDriverRepository $transportDriverRepository
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(TransportDriverRepository $transportDriverRepository, SupplierRepository $supplierRepository)
    {
        $this->transportDriverRepository = $transportDriverRepository;
        $this->supplierRepository = $supplierRepository;
    }

    public function handle(FilterTransportDriverQuery $query): FilterTransportDriverResponse
    {
        $filterCollection = $this->setCriteria($query);

        $sortCollection = null;
        if (!empty($query->getSortBy()) && !empty($query->getOrder())) {
            $sortCollection = new SortCollection([
                new Sort($query->getSortBy(), $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);

        $transportDriverGetByResponse = $this->transportDriverRepository->getBy(new TransportDriverCriteria($filterCollection, $pagination));

        $supplierCollection = $this->supplierRepository->getBy(new SupplierCriteria())->getCollection();

        $transportDriverList = [];
        /**
         * @var TransportDriver $transportDriver
         */
        foreach ($transportDriverGetByResponse->getCollection() as $transportDriver) {
            $providerName = null;

            if ($transportDriver->getTransportProviderId()) {
                try {
                    $providerName = $supplierCollection->getByProperty($transportDriver->getTransportProviderId(), "id")->getName();
                } catch (Exception $e) {
                    continue;
                }
            }

            $transportDriverList[] = [
                'id' => $transportDriver->getId(),
                'internalDriver' => $transportDriver->isInternalDriver(),
                // 'rgoUserId' => $transportDriver->getRgoUserId(),
                // 'provider' => $transportDriver->getProvider(),
                'providerId' => $transportDriver->getTransportProviderId(),
                'provider' => [
                    'id' => $transportDriver->getTransportProviderId(),
                    'name' => $providerName,
                ],
                'name' => $transportDriver->getName(),
                'lastName' => $transportDriver->getLastName(),
                'idNumber' => $transportDriver->getIdNumber(),
                'driverLicense' => $transportDriver->getDriverLicense(),
                'issueDate' => $transportDriver->getIssueDate(),
                'expirationDate' => $transportDriver->getExpirationDate(),
                'city' => $transportDriver->getCity(),
                // 'state' => $transportDriver->getState(),
                'state' => [
                    'name' => $transportDriver->getState(),
                ],
                'country' => $transportDriver->getCountry(),
                'postalCode' => $transportDriver->getPostalCode(),
                'address' => $transportDriver->getAddress(),
                // 'branch' => $transportDriver->getBranch(),
                'branch' => [
                    'id' => $transportDriver->getBranchId(),
                ],
            ];
        }

        $transportDriverArray['total'] = $transportDriverGetByResponse->getTotalRows();
        $transportDriverArray['rows'] = $transportDriverList;

        return new FilterTransportDriverResponse($transportDriverArray);
    }

    private function setCriteria(FilterTransportDriverQuery $query): FilterCollection
    {
        $filterFleetCollection =  new FilterCollection([]);

        if (!empty($query->getName())) $filterFleetCollection->add(new Filter('EXTDRIVERSNAME', new FilterOperator(FilterOperator::EQUAL), $query->getName()));

        if (!empty($query->getLastName())) $filterFleetCollection->add(new Filter('EXTDRIVERSLASTNAME', new FilterOperator(FilterOperator::EQUAL), $query->getLastName()));

        if (!empty($query->getIdNumber())) $filterFleetCollection->add(new Filter('EXTDRIVERIDNUM', new FilterOperator(FilterOperator::EQUAL), $query->getIdNumber()));

        if (!empty($query->getDriverLicense())) $filterFleetCollection->add(new Filter('EXTDRIVERDL', new FilterOperator(FilterOperator::EQUAL), $query->getDriverLicense()));

        // if (!empty($query->getIssueDate())) $filterFleetCollection->add(new Filter('DLISSUEDATE', new FilterOperator(FilterOperator::EQUAL), $query->getIssueDate()));

        // if (!empty($query->getExpiringDate())) $filterFleetCollection->add(new Filter('DLEXPIRATIONDATE', new FilterOperator(FilterOperator::EQUAL), $query->getExpiringDate()));

        // if (!empty($query->getCity())) $filterFleetCollection->add(new Filter('EXTDRIVERCITY', new FilterOperator(FilterOperator::EQUAL), $query->getCity()));

        // if (!empty($query->getCountryId())) $filterFleetCollection->add(new Filter('COUNTRYDESCRIPTION', new FilterOperator(FilterOperator::EQUAL), $query->getCountryId()));

        return $filterFleetCollection;
    }
}
