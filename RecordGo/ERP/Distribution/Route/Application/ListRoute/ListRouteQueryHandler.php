<?php

namespace Distribution\Route\Application\ListRoute;

use Shared\Utils\Utils;
use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Branch\Domain\BranchException;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\Supplier\Domain\SupplierCriteria;
use Distribution\Supplier\Domain\SupplierException;
use Distribution\Supplier\Domain\SupplierRepository;
use Distribution\TransportMethod\Domain\TransportMethodCriteria;
use Distribution\TransportMethod\Domain\TransportMethodException;
use Distribution\TransportMethod\Domain\TransportMethodRepository;

class ListRouteQueryHandler
{
    /**
     * @var TransportMethodRepository
     */
    private $transportMethodRepository;
    /**
     * @var SupplierRepository
     */
    private $providerRepository;

    /**
     * @var BranchRepository
     */
    private $branchRepository;

    /**
     * ListRouteQueryHandler constructor.
     *
     * @param TransportMethodRepository $transportMethodRepository
     * @param SupplierRepository $providerRepository
     * @param BranchRepository $branchRepository
     */
    public function __construct(
        TransportMethodRepository $transportMethodRepository,
        SupplierRepository $providerRepository,
        BranchRepository $branchRepository
    ) {
        $this->transportMethodRepository = $transportMethodRepository;
        $this->providerRepository = $providerRepository;
        $this->branchRepository = $branchRepository;
    }

    /**
     * @return ListRouteResponse
     */
    public function handle(): ListRouteResponse
    {
        $transportMethodCollection = $this->transportMethodRepository->getBy(new TransportMethodCriteria())->getCollection();
        if (empty($transportMethodCollection)) {
            throw new TransportMethodException('Error getting transport method');
        }

        $providerCollection = $this->providerRepository->getBy(new SupplierCriteria())->getCollection();
        if (empty($providerCollection)) {
            throw new SupplierException('Error getting supplier');
        }

        $branchCollection = $this->branchRepository->getBy(new BranchCriteria())->getCollection();
        if (empty($branchCollection)) {
            throw new BranchException('Error getting branch');
        }


        $transportMethodList = Utils::createSelect($transportMethodCollection);
        $branchList = Utils::createSelect($branchCollection);
        $providerList = Utils::createSelect($providerCollection);


        $selectList = [
            'transportMethodList' => $transportMethodList,
            'branchList' => $branchList,
            'providerList' => $providerList,
        ];

        return new ListRouteResponse($selectList);
    }
}
