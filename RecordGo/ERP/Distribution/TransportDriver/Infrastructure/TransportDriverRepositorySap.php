<?php

namespace Distribution\TransportDriver\Infrastructure;

use Closure;
use Shared\Repository\RepositoryHelper;
use Distribution\TransportDriver\Domain\TransportDriver;
use Distribution\TransportDriver\Domain\TransportDriverCriteria;
use Distribution\TransportDriver\Domain\TransportDriverException;
use Distribution\TransportDriver\Domain\TransportDriverCollection;
use Distribution\TransportDriver\Domain\TransportDriverRepository;
use Distribution\TransportDriver\Domain\TransportDriverGetByResponse;
use Distribution\TransportDriver\Domain\TransportDriverNotFoundException;

class TransportDriverRepositorySap extends RepositoryHelper implements TransportDriverRepository
{
    const PREFIX_FUNCTION_NAME = 'TransportDriver/TransportDriverRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getBy(TransportDriverCriteria $criteria): TransportDriverGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new TransportDriverCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TTransportDriverResponse', $collection, Closure::fromCallable([$this, 'arrayToTransportDriver']));

            return (new TransportDriverGetByResponse($collection, $totalRows ?? 0));
        } catch (\Exception $exception) {
            throw new TransportDriverNotFoundException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getById($id): TransportDriver
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $transportDriverArray = $this->genericGetById('GET', $functionName, 'TTransportDriverResponse');

            return $this->arrayToTransportDriver($transportDriverArray);
        } catch (\Exception $exception) {
            throw new TransportDriverException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function store(TransportDriver $transportDriver): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        try {
            $transportDriverArray = $transportDriver->toArray();
            /**
             * A fecha y hora de 21-07-2023 11:29, se necesita adjuntar si el transportDriver está activo o no (no permite enviar nulo).
             * El campo blocknote permite omitirlo
             */
            $transportDriverArray["EXTDRIVERACTIVE"] = 1;
            $body = json_encode($transportDriverArray);

            $response = $this->genericSave('POST', $functionName, $body);

            return $response;
        } catch (\Exception $exception) {
            throw new TransportDriverException($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @param array $transportDriverArray
     * @return TransportDriver
     */
    private function arrayToTransportDriver(array $transportDriverArray): TransportDriver
    {
        return TransportDriver::createFromArray($transportDriverArray);
    }
}
