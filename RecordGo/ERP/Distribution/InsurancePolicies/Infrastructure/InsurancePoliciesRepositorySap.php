<?php

namespace Distribution\InsurancePolicies\Infrastructure;

use Exception;
use App\Constants\ErrorConstants;
use Shared\Repository\RepositoryHelper;
use Distribution\InsurancePolicies\Domain\InsurancePolicies;
use Distribution\InsurancePolicies\Domain\InsurancePoliciesCollection;
use Distribution\InsurancePolicies\Domain\InsurancePoliciesRepository;
use Distribution\InsurancePolicies\Domain\InsurancePoliciesGetByResponse;

class InsurancePoliciesRepositorySap extends RepositoryHelper implements InsurancePoliciesRepository
{
    const PREFIX_FUNCTION_NAME = 'InsurancePolicies/InsurancePoliciesRepository_Mostrador';

    /**
     * @inheritDoc
     */
    public function getByVehicleId(int $vehicleId): InsurancePoliciesGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $vehicleId;
        $collection = new InsurancePoliciesCollection([]);

        try {
            $response  = $this->sapRequestHelper->request('GET', $functionName, '');
            $responseArray = json_decode($response, true);

            $this->errorHandling($responseArray, $response, 'TInsurancePoliciesResponse');
            // if (isset($responseArray['errorCode'])) {
            //     $code = is_numeric($responseArray['errorCode']) ? intval($responseArray['errorCode']) : 500;
            //     $message = $code == 500 ? ErrorConstants::CHECK_WITH_DEVELOP_MESSAGE : $responseArray['errorDescription'];
            //     throw new Exception($message, $code);
            // }

            foreach ($responseArray['TInsurancePoliciesResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToInsurancePolicies($itemArray));
                } catch (Exception $exception) {
                    throw new Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return new InsurancePoliciesGetByResponse($collection, $totalRows ?? 0);
    }


    private function arrayToInsurancePolicies(array $insurancePoliciesArray): InsurancePolicies
    {
        return InsurancePolicies::createFromArray($insurancePoliciesArray);
    }
}
