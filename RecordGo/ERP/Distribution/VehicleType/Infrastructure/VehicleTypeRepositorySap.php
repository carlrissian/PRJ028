<?php
declare(strict_types=1);


namespace Distribution\VehicleType\Infrastructure;

use Closure;
use Distribution\VehicleType\Domain\VehicleType;
use Distribution\VehicleType\Domain\VehicleTypeCollection;
use Distribution\VehicleType\Domain\VehicleTypeCriteria;
use Distribution\VehicleType\Domain\VehicleTypeGetByResponse;
use Distribution\VehicleType\Domain\VehicleTypeRepository;
use Exception;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Shared\Repository\RepositoryHelper;


class VehicleTypeRepositorySap extends RepositoryHelper implements VehicleTypeRepository
{

    private const PREFIX_FUNCTION_NAME = 'VehicleType/VehicleTypeRepository';

    /**
     * @param SapRequestHelper $sapRequestHelper
     */
    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    public function getBy(VehicleTypeCriteria $criteria): VehicleTypeGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new VehicleTypeCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TVehicleTypeResponse', $collection, Closure::fromCallable([$this, 'arrayToVehicleType']));

            return new VehicleTypeGetByResponse($collection, $totalRows ?? 0);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    final public function arrayToVehicleType(array $arrayType): VehicleType
    {
        return new VehicleType(intval($arrayType['ID']), $arrayType['CARTYPENAME']);
    }

}