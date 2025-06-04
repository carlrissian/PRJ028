<?php

declare(strict_types=1);

namespace Distribution\CarBodyType\Infrastructure;

use Closure;

use Distribution\CarBodyType\Domain\CarBodyType;
use Distribution\CarBodyType\Domain\CarBodyTypeCollection;
use Distribution\CarBodyType\Domain\CarBodyTypeCriteria;
use Distribution\CarBodyType\Domain\CarBodyTypeGetByResponse;
use Distribution\CarBodyType\Domain\CarBodyTypeRepository;
use Exception;
use Shared\Repository\RepositoryHelper;
use Shared\Domain\RequestHelper\SapRequestHelper;

class CarBodyTypeRepositorySap extends RepositoryHelper implements CarBodyTypeRepository
{
    private const PREFIX_FUNCTION_NAME = 'BodyType/BodyTypeRepository';

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(CarBodyTypeCriteria $criteria): CarBodyTypeGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new CarBodyTypeCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TBodyTypeResponse', $collection, Closure::fromCallable([$this, 'arrayToBodyType']));

            return new CarBodyTypeGetByResponse($collection, $totalRows);

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }



    final public function arrayToBodyType(array $bodyTypeArray): CarBodyType
    {
        return CarBodyType::createFromArray($bodyTypeArray);
    }
}
