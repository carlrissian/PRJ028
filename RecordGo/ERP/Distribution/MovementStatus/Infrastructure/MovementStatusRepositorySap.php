<?php

declare(strict_types=1);

namespace Distribution\MovementStatus\Infrastructure;

use Closure;
use Exception;
use Shared\Repository\RepositoryHelper;
use Distribution\MovementStatus\Domain\MovementStatus;
use Distribution\MovementStatus\Domain\MovementStatusCriteria;
use Distribution\MovementStatus\Domain\MovementStatusCollection;
use Distribution\MovementStatus\Domain\MovementStatusRepository;
use Distribution\MovementStatus\Domain\MovementStatusGetByResponse;

class MovementStatusRepositorySap extends RepositoryHelper implements MovementStatusRepository
{
    private const PREFIX_FUNCTION_NAME = 'MovementStatus/MovementStatusRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(MovementStatusCriteria $criteria): MovementStatusGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new MovementStatusCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TMovementStatusResponse', $collection, Closure::fromCallable([$this, 'arrayToMovementStatus']));

            return new MovementStatusGetByResponse($collection, $totalRows);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @param array $movementStatusArray
     * @return MovementStatus
     */
    final public function arrayToMovementStatus(array $movementStatusArray): MovementStatus
    {
        return MovementStatus::createFromArray($movementStatusArray);
    }
}
