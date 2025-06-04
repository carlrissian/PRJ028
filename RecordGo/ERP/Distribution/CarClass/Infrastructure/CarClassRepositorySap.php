<?php

declare(strict_types=1);

namespace Distribution\CarClass\Infrastructure;

use Closure;

use Distribution\CarBodyType\Domain\CarBodyTypeCollection;
use Distribution\CarBodyType\Domain\CarBodyTypeCriteria;
use Distribution\CarBodyType\Domain\CarBodyTypeGetByResponse;
use Distribution\CarBodyType\Domain\CarBodyTypeRepository;
use Distribution\CarBodyType\Infrastructure\BusinessUnit;
use Distribution\CarClass\Domain\CarClass;
use Distribution\CarClass\Domain\CarClassCriteria;
use Distribution\CarClass\Domain\CarClassGetByResponse;
use Distribution\CarClass\Domain\CarClassRepository;
use Exception;
use Shared\Repository\RepositoryHelper;
use Shared\Domain\RequestHelper\SapRequestHelper;

class CarClassRepositorySap extends RepositoryHelper implements CarClassRepository
{
    private const PREFIX_FUNCTION_NAME = 'CarClass/CarClassRepository';

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(CarClassCriteria $criteria): CarClassGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new CarBodyTypeCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TCarCLassResponse', $collection, Closure::fromCallable([$this, 'arrayToCarClass']));

            return new CarClassGetByResponse($collection, $totalRows);

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }



    final public function arrayToCarClass(array $carClassArray): CarClass
    {
        return CarClass::createFromArray($carClassArray);
    }

    public function getById(int $id): CarClass
    {
        // TODO: Implement getById() method.
    }

    public function getByAcrissLetter(string $acrissLetter): CarClass
    {
        // TODO: Implement getByAcrissLetter() method.
    }

    public function activate(int $id, bool $carClassStatus): ?CarClass
    {
        // TODO: Implement activate() method.
    }
}
