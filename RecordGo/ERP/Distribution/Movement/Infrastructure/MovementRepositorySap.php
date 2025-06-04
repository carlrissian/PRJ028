<?php

namespace Distribution\Movement\Infrastructure;

use Exception;
use Shared\Domain\OperationResponse;
use Shared\Repository\RepositoryHelper;
use Distribution\Movement\Domain\Movement;
use Distribution\Movement\Domain\MovementCriteria;
use Distribution\Movement\Domain\MovementCollection;
use Distribution\Movement\Domain\MovementRepository;
use Distribution\Movement\Domain\MovementGetByResponse;
use Distribution\Movement\Domain\VehicleLineCollection;
use Distribution\Movement\Domain\ListVehicleGetByResponse;
use Distribution\Movement\Domain\VehicleLineGetByResponse;
use Distribution\Movement\Domain\MovementOperationResponse;
use Distribution\Movement\Domain\MovementVehicleLineCollection;

class MovementRepositorySap extends RepositoryHelper implements MovementRepository
{
    private const PREFIX_FUNCTION_NAME = 'Movement/MovementRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(MovementCriteria $Criteria): MovementGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new MovementCollection([]);

        try {
            $body = json_encode(parent::createCriteria($Criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);
            $responseArray = json_decode($response, true);

            foreach ($responseArray['TMovementListResponse'] as $itemArray) {
                try {
                    $collection->add(MovementCreator::arrayToMovement($itemArray));
                } catch (Exception $exception) {
                    throw new Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return new MovementGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getByVehicles(MovementCriteria $Criteria): ListVehicleGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new MovementVehicleLineCollection([]);

        try {
            $body = json_encode(parent::createCriteria($Criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);
            $responseArray = json_decode($response, true);

            foreach ($responseArray['TMovementVehicleLineResponse'] as $itemArray) {
                try {
                    $collection->add(MovementVehicleLineCreator::arrayToMovementVehicleLine($itemArray));
                } catch (Exception $exception) {
                    throw new Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return new ListVehicleGetByResponse($collection, $totalRows);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getAssignedVehicles(int $movementId, MovementCriteria $Criteria): VehicleLineGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $movementId;
        $collection = new VehicleLineCollection([]);

        try {
            $body = json_encode(parent::createCriteria($Criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new Exception("The getBy request hasn't returned a response");
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TVehicleLineResponse');

            foreach ($responseArray['TVehicleLineResponse'] as $itemArray) {
                $collection->add(VehicleLineCreator::arrayToVehicleLine($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return new VehicleLineGetByResponse($collection, $totalRows);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getById(int $id): Movement
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $response  = $this->sapRequestHelper->request('GET', $functionName, '');
            $responseArray = json_decode($response, true);

            return MovementCreator::arrayToMovement($responseArray['TMovementResponse'][0]);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function store(Movement $movement): MovementOperationResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        try {
            $body = json_encode($movement->toArray());

            $response = $this->sapRequestHelper->request('POST', $functionName, $body);
            $responseArray = json_decode($response, true);

            return new MovementOperationResponse(
                isset($responseArray['ID']) ? intval($responseArray['ID']) : null,
                OperationResponse::createFromArray($responseArray['TOperationResponse'])
            );
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function update(Movement $movement): MovementOperationResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $movement->getId();

        try {
            $body = json_encode($movement->toArray());

            $response = $this->sapRequestHelper->request('PATCH', $functionName, $body);
            $responseArray = json_decode($response, true);

            return new MovementOperationResponse(
                isset($responseArray['ID']) ? intval($responseArray['ID']) : null,
                OperationResponse::createFromArray($responseArray['TOperationResponse'])
            );
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}
