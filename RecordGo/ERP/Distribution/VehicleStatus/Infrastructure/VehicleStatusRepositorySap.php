<?php

declare(strict_types=1);

namespace Distribution\VehicleStatus\Infrastructure;

use Closure;
use Exception;
use Shared\Repository\RepositoryHelper;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Distribution\VehicleStatus\Domain\VehicleStatus;
use Distribution\VehicleStatus\Domain\VehicleStatusCriteria;
use Distribution\VehicleStatus\Domain\VehicleStatusCollection;
use Distribution\VehicleStatus\Domain\VehicleStatusRepository;
use Distribution\VehicleStatus\Domain\VehicleStatusGetByResponse;

class VehicleStatusRepositorySap extends RepositoryHelper implements VehicleStatusRepository
{
    private const PREFIX_FUNCTION_NAME = 'VehicleStatus/VehicleStatusRepository';

    /**
     * @param SapRequestHelper $sapRequestHelper
     */
    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(VehicleStatusCriteria $vehicleCriteria): VehicleStatusGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new VehicleStatusCollection([]);

        try {
            $body = json_encode(parent::createCriteria($vehicleCriteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TVehicleStatusResponse', $collection, Closure::fromCallable([$this, 'arrayToVehicleStatus']));

            return (new VehicleStatusGetByResponse($collection, $totalRows ?? 0));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function getById(int $id): ?VehicleStatus
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

    //     try {
    //         $carArray = $this->genericGetById('GET', $functionName, 'TVehicleStatusResponse');

    //         return $this->arrayToVehicleStatus($carArray);
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }
    // }


    /**
     * @throws Exception
     */
    final public function arrayToVehicleStatus(array $vehicleStatusArray): VehicleStatus
    {
        return VehicleStatus::createFromArray($vehicleStatusArray);
    }
}
