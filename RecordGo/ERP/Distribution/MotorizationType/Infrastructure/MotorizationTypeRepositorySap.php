<?php
declare(strict_types=1);


namespace Distribution\MotorizationType\Infrastructure;


use Closure;
use Distribution\MotorizationType\Domain\MotorizationType;
use Distribution\MotorizationType\Domain\MotorizationTypeCollection;
use Distribution\MotorizationType\Domain\MotorizationTypeCriteria;
use Distribution\MotorizationType\Domain\MotorizationTypeGetByResponse;
use Distribution\MotorizationType\Domain\MotorizationTypeRepository;
use Exception;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Shared\Repository\RepositoryHelper;
use Shared\Utils\Utils;

class MotorizationTypeRepositorySap extends RepositoryHelper implements  MotorizationTypeRepository
{
    private const PREFIX_FUNCTION_NAME = 'MotorType/MotorTypeRepository';

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(MotorizationTypeCriteria $criteria): MotorizationTypeGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new MotorizationTypeCollection([]);

        try {
            $body = json_encode(Utils::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TMotorTypeResponse', $collection, Closure::fromCallable([$this, 'arrayToMotorType']));

            return new MotorizationTypeGetByResponse($collection, $totalRows);

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    public function getById(int $id): ?MotorizationType
    {
        // TODO: Implement getById() method.
    }

    final public function arrayToMotorType(array $motorTypeArray): MotorizationType
    {
        return MotorizationType::createFromArray($motorTypeArray);
    }


}