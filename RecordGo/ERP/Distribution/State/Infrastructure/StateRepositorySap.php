<?php

declare(strict_types=1);

namespace Distribution\State\Infrastructure;

use Closure;
use Exception;
use Distribution\State\Domain\State;
use Shared\Repository\RepositoryHelper;
use Distribution\State\Domain\StateCriteria;
use Distribution\State\Domain\StateCollection;
use Distribution\State\Domain\StateRepository;
use Distribution\State\Domain\StateGetByResponse;

class StateRepositorySap extends RepositoryHelper implements StateRepository
{
    private const PREFIX_FUNCTION_NAME = 'State/StateRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(StateCriteria $criteria): StateGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new StateCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TStateResponse', $collection, Closure::fromCallable([$this, 'arrayToState']));

            return new StateGetByResponse($collection, $totalRows);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    final public function arrayToState(array $stateArray): State
    {
        return State::createFromArray($stateArray);
    }
}
