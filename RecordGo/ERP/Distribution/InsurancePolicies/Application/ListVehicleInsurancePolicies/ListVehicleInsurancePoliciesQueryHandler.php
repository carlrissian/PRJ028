<?php

namespace Distribution\InsurancePolicies\Application\ListVehicleInsurancePolicies;

use Distribution\InsurancePolicies\Domain\InsurancePolicies;
use Distribution\InsurancePolicies\Domain\InsurancePoliciesRepository;

class ListVehicleInsurancePoliciesQueryHandler
{
    /**
     * @var InsurancePoliciesRepository
     */
    private InsurancePoliciesRepository $insurancePoliciesRepository;

    /**
     * @param InsurancePoliciesRepository $insurancePoliciesRepository
     */
    public function __construct(InsurancePoliciesRepository $insurancePoliciesRepository)
    {
        $this->insurancePoliciesRepository = $insurancePoliciesRepository;
    }

    public function handle(ListVehicleInsurancePoliciesQuery $query): ListVehicleInsurancePoliciesResponse
    {
        $response = $this->insurancePoliciesRepository->getByVehicleId($query->getVehicleId());

        // $insurancePoliciesArray = [];

        // foreach ($response->getCollection() as $insurancePolicy) {
        //     /**
        //      * @var InsurancePolicies $insurancePolicy
        //      */
        //     $insurancePoliciesArray[] = [
        //         'id' => $insurancePolicy->getId(),
        //         'policyCompany' => $insurancePolicy->getPolicyCompany()->getName(),
        //         'policyBroker' => $insurancePolicy->getPolicyBroker()->getName(),
        //         'policyNumber' => $insurancePolicy->getPolicyNumber(),
        //         'policyType' => $insurancePolicy->getPolicyType()->getName(),
        //         'activationDate' => $insurancePolicy->getActivationDate(),
        //         'endDate' => $insurancePolicy->getFinishDate(),
        //         'policyStatus' => $insurancePolicy->getPolicyStatus()->getName()
        //     ];
        // }

        $insurancePoliciesArray = array_filter($response->getCollection()->toArray(), function ($insurancePolicy) {
            /**
             * @var InsurancePolicies $insurancePolicy
             */
            return $insurancePolicy->getActivationDate() !== null;
        });

        return new ListVehicleInsurancePoliciesResponse($insurancePoliciesArray, $response->getTotalRows());
    }
}
