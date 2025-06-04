<?php

namespace Distribution\RentalAgreement\Infrastructure;

use Shared\Repository\RepositoryHelper;
use Distribution\RentalAgreement\Domain\RentalAgreementRepository;
use Distribution\RentalAgreement\Domain\ListLite\RentalAgreementListLite;
use Distribution\RentalAgreement\Domain\ListLite\RentalAgreementListLiteCollection;
use Distribution\RentalAgreement\Domain\ListLite\RentalAgreementListLiteGetByResponse;

class RentalAgreementRepositorySap extends RepositoryHelper implements RentalAgreementRepository
{
    const PREFIX_FUNCTION_NAME = 'RentalAgreement/RentalAgreementRepository_Mostrador';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getByVehicle(int $vehicleId): RentalAgreementListLiteGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $vehicleId;
        $collection = new RentalAgreementListLiteCollection([]);

        try {
            $response  = $this->sapRequestHelper->request('GET', $functionName, "");
            $responseArray = json_decode($response, true);

            foreach ($responseArray['TRentalAgreementListLiteResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToRentalAgreementListLite($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), 500);
        }

        return new RentalAgreementListLiteGetByResponse($collection, $totalRows ?? 0);
    }


    /**
     * @throws Exception
     */
    final public function arrayToRentalAgreementListLite(array $rentalAgreementListLiteArray): RentalAgreementListLite
    {
        return RentalAgreementListLite::createFromArray($rentalAgreementListLiteArray);
    }
}
