<?php

namespace Distribution\StopSale\Infrastructure;

use Shared\Utils\Utils;
use Distribution\StopSale\Domain\StopSale;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Distribution\StopSale\Domain\StopSaleCriteria;
use Distribution\StopSale\Domain\StopSaleCollection;
use Distribution\StopSale\Domain\StopSaleRepository;
use Distribution\StopSale\Domain\StopSaleGetByResponse;
use Distribution\StopSale\Domain\Exception\StopSaleException;

final class StopSaleRepositorySap implements StopSaleRepository
{
    private const PREFIX_FUNCTION_NAME = 'StopSale/StopSaleRepository';

    /**
     * @var SapRequestHelper $sapRequestHelper
     */
    private SapRequestHelper $sapRequestHelper;

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        $this->sapRequestHelper = $sapRequestHelper;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getBy(StopSaleCriteria $criteria): StopSaleGetByResponse
    {
        $functionName = sprintf('%s_%s', self::PREFIX_FUNCTION_NAME, __FUNCTION__);
        $collection = new StopSaleCollection([]);

        try {
            $body = json_encode(Utils::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);
            if (empty($response)) {
                throw new StopSaleException(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);

            foreach ($responseArray['TStopSaleResponse'] as $itemArray) {
                $collection->add($this->arrayToStopSale($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();

            return new StopSaleGetByResponse($collection, $totalRows ?? 0);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getStopSaleHistoryById(int $stopSaleId): StopSaleGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_history/' . $stopSaleId;
        $collection = new StopSaleCollection([]);

        try {
            $response  = $this->sapRequestHelper->request('GET', $functionName, '');
            if (empty($response)) {
                throw new StopSaleException(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);

            foreach ($responseArray['TStopSaleResponse'] as $itemArray) {
                $collection->add($this->arrayToStopSale($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();

            return new StopSaleGetByResponse($collection, $totalRows ?? 0);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getById(int $id): ?StopSale
    {
        $functionName = sprintf('%s_%s/%d', self::PREFIX_FUNCTION_NAME, __FUNCTION__, $id);

        try {
            $response  = $this->sapRequestHelper->request('GET', $functionName, '');
            $responseArray = json_decode($response, true);

            return isset($responseArray['TStopSaleResponse']) && count($responseArray['TStopSaleResponse']) > 0
                ? $this->arrayToStopSale($responseArray['TStopSaleResponse'][0])
                : null;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function store(StopSale $stopSale): int
    {
        $functionName = sprintf('%s_%s', self::PREFIX_FUNCTION_NAME, __FUNCTION__);

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
    public function update(StopSale $stopSale): int
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
    public function arrayToStopSale(array $stopSaleArray): StopSale
    {
        return StopSale::createFromArray($stopSaleArray);
    }
}
