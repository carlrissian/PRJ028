<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Infrastructure;

use Exception;
use Shared\Domain\OperationResponse;
use Shared\Repository\RepositoryHelper;
use Distribution\Vehicle\Domain\Vehicle;
use Distribution\Vehicle\Domain\VehicleHistory;
use Distribution\Vehicle\Domain\VehicleCriteria;
use Distribution\Vehicle\Domain\VehicleToUpdate;
use Distribution\Vehicle\Domain\VehicleCollection;
use Distribution\Vehicle\Domain\VehicleRepository;
use Distribution\Vehicle\Domain\VehicleAnticipation;
use Distribution\Vehicle\Domain\VehicleGetByResponse;
use Distribution\Vehicle\Domain\VehicleHistoryCriteria;
use Distribution\Vehicle\Domain\VehicleToAssignCriteria;
use Distribution\Vehicle\Domain\VehicleHistoryCollection;
use Distribution\Vehicle\Domain\VehiclesToUpdateCriteria;
use Distribution\Vehicle\Domain\VehicleToUpdateCollection;
use Distribution\Vehicle\Domain\VehicleHistoryGetByResponse;
use Distribution\Vehicle\Domain\VehicleAnticipationCollection;
use Distribution\Vehicle\Domain\VehicleAnticipationsGetByResponse;

class VehicleRepositorySap extends RepositoryHelper implements VehicleRepository
{
    private const PREFIX_FUNCTION_NAME = 'Vehicle/VehicleRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(VehicleCriteria $criteria): VehicleGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new VehicleCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));
            
            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TVehicleResponse');

            foreach ($responseArray['TVehicleResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToVehicle($itemArray));
                } catch (Exception $exception) {
                    throw new Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 500);
        }

        return new VehicleGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getById(int $id): ?Vehicle
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_Mostrador_' . __FUNCTION__ . '/' . $id;

        try {
            $response  = $this->sapRequestHelper->request('GET', $functionName, '');
            $responseArray = json_decode($response, true);

            return $this->arrayToVehicle($responseArray['TVehicleResponse'][0]);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getVehicleHistoryBy(VehicleHistoryCriteria $criteria): VehicleHistoryGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_history_getBy';
        $collection = new VehicleHistoryCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TVehicleHistoryResponse');

            foreach ($responseArray['TVehicleHistoryResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToVehicleHistory($itemArray));
                } catch (Exception $exception) {
                    throw new Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 500);
        }

        return new VehicleHistoryGetByResponse($collection, $totalRows ?? 0);
    }


    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getVehiclesToUpdateBy(VehiclesToUpdateCriteria $criteria): VehicleToUpdateCollection
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new VehicleToUpdateCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TVehicleToUpdateResponse');

            foreach ($responseArray['TVehicleToUpdateResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToVehicleToUpdate($itemArray));
                } catch (Exception $exception) {
                    throw new Exception($exception->getMessage(), $exception->getCode());
                }
            }
            // $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 500);
        }

        return $collection;
    }

    /**
     * @inheritDoc
     */
    public function getVehiclesToAssignBy(VehicleToAssignCriteria $criteria)
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new VehicleCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TVehicleResponse');

            foreach ($responseArray['TVehicleResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToVehicle($itemArray));
                } catch (Exception $exception) {
                    throw new Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();

            $error = isset($responseArray['TOperationResponse']) && $responseArray['TOperationResponse']['CODE'] == 460;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 500);
        }

        return $error ? OperationResponse::createFromArray($responseArray['TOperationResponse']) : new VehicleGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     */
    final public function getVehicleAnticipationsByVehicleId(int $vehicleId): VehicleAnticipationsGetByResponse
    {
        $functionName = 'Vehicle/VehicleAnticipationRepository_getById/' . $vehicleId;

        $collection = new VehicleAnticipationCollection([]);

        try {
            $response  = $this->sapRequestHelper->request('GET', $functionName, '');
            $responseArray = json_decode($response, true);

            foreach ($responseArray['TVehicleAnticipationResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToVehicleAnticipation($itemArray));
                } catch (Exception $exception) {
                    throw new Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 500);
        }

        return new VehicleAnticipationsGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function update(Vehicle $vehicle): ?int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $vehicle->getId();

        try {
            $body = json_encode($vehicle->toArray());

            $response = $this->sapRequestHelper->request('PATCH', $functionName, $body);
            $responseArray = json_decode($response, true);

            return intval($responseArray['ID']);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 500);
        }
    }


    /**
     * @throws Exception
     */
    final public function arrayToVehicle(array $vehicleArray): Vehicle
    {
        return Vehicle::createFromArray($vehicleArray);
    }

    /**
     * @throws Exception
     */
    final public function arrayToVehicleHistory(array $vehicleHistoryArray): VehicleHistory
    {
        return VehicleHistory::createFromArray($vehicleHistoryArray);
    }

    /**
     * @throws Exception
     */
    final public function arrayToVehicleToUpdate(array $vehicleToUpdateArray): VehicleToUpdate
    {
        return VehicleToUpdate::createFromArray($vehicleToUpdateArray);
    }

    /**
     * @throws Exception
     */
    final public function arrayToVehicleAnticipation(array $vehicleAnticipationArray): VehicleAnticipation
    {
        return VehicleAnticipation::createFromArray($vehicleAnticipationArray);
    }
}
