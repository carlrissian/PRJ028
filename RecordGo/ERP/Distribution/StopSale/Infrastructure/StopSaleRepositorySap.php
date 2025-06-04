<?php

declare(strict_types=1);

namespace Distribution\StopSale\Infrastructure;

use Shared\Repository\RepositoryHelper;
use Distribution\StopSale\Domain\StopSale;
use Distribution\StopSale\Domain\StopSaleCriteria;
use Distribution\StopSale\Domain\StopSaleCollection;
use Distribution\StopSale\Domain\StopSaleRepository;
use Distribution\StopSale\Domain\StopSaleGetByResponse;

class StopSaleRepositorySap extends RepositoryHelper implements StopSaleRepository
{
    private const PREFIX_FUNCTION_NAME = 'StopSale/StopSaleRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(StopSaleCriteria $criteria): StopSaleGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new StopSaleCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TStopSaleResponse');

            foreach ($responseArray['TStopSaleResponse'] as $itemArray) {
                $collection->add($this->arrayToStopSale($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new StopSaleGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getStopSaleHistoryById(int $stopSaleId): StopSaleGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_history/' . $stopSaleId;
        $collection = new StopSaleCollection([]);

        try {
            $response  = $this->sapRequestHelper->request('GET', $functionName, '');

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TStopSaleResponse');

            foreach ($responseArray['TStopSaleResponse'] as $itemArray) {
                $collection->add($this->arrayToStopSale($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new StopSaleGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getById(int $id): ?StopSale
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $response  = $this->sapRequestHelper->request('GET', $functionName, '');

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TStopSaleResponse');

            return count($responseArray['TStopSaleResponse']) > 0 ? $this->arrayToStopSale($responseArray['TStopSaleResponse'][0]) : null;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function store(StopSale $stopSale): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        try {
            $body = json_encode($stopSale->toArray());

            $response = $this->sapRequestHelper->request('POST', $functionName, $body);
            $responseArray = json_decode($response, true);

            return intval($responseArray['ID']);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function update(StopSale $stopSale): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $stopSale->getId();

        try {
            $body = json_encode($stopSale->toArray());

            $response = $this->sapRequestHelper->request('PATCH', $functionName, $body);
            $responseArray = json_decode($response, true);

            return intval($responseArray['ID']);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @param array $stopSaleArray
     * @return StopSale
     */
    final public function arrayToStopSale(array $stopSaleArray): StopSale
    {
        return StopSale::createFromArray($stopSaleArray);
    }
}
