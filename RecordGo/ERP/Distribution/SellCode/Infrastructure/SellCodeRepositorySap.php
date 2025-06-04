<?php

namespace Distribution\SellCode\Infrastructure;

use Shared\Repository\RepositoryHelper;
use Distribution\SellCode\Domain\SellCode;
use Distribution\SellCode\Domain\SellCodeCriteria;
use Distribution\SellCode\Domain\SellCodeCollection;
use Distribution\SellCode\Domain\SellCodeRepository;
use Distribution\SellCode\Domain\SellCodeGetByResponse;

class SellCodeRepositorySap extends RepositoryHelper implements SellCodeRepository
{
    const PREFIX_FUNCTION_NAME = 'SellCodes/SellCodeRepository';

    /**
     * @inheritDoc
     */
    public function getBy(SellCodeCriteria $criteria): SellCodeGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new SellCodeCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TSellCodeResponse');

            foreach ($responseArray['TSellCodeResponse'] as $itemArray) {
                $collection->add($this->arrayToSellCode($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new SellCodeGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): SellCode
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $response  = $this->sapRequestHelper->request('GET', $functionName, '');

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TSellCodeResponse');

            return $this->arrayToSellCode($responseArray['TSellCodeResponse'][0]);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @param array $sellCodeArray
     * @return SellCode
     */
    final private function arrayToSellCode(array $sellCodeArray): SellCode
    {
        return SellCode::createFromArray($sellCodeArray);
    }
}
