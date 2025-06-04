<?php

declare(strict_types=1);

namespace Distribution\Route\Infrastructure;

use Closure;
use Exception;
use Shared\Utils\Utils;
use Distribution\Route\Domain\Route;
use Shared\Repository\RepositoryHelper;
use Distribution\Route\Domain\RouteCriteria;
use Distribution\Route\Domain\RouteCollection;
use Distribution\Route\Domain\RouteRepository;
use Distribution\Route\Domain\RouteGetByResponse;
use Distribution\Route\Domain\RouteGetByAutomaticCostRequest;
use Distribution\Route\Domain\RouteGetByAutomaticCostResponse;

class RouteRepositorySap extends RepositoryHelper implements RouteRepository
{
    private const PREFIX_FUNCTION_NAME = 'Route/RouteRepository';

    /**
     * @inheritDoc
     */
    final public function getBy(RouteCriteria $criteria): RouteGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new RouteCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TRouteResponse', $collection, Closure::fromCallable([$this, 'arrayToRoute']));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return new RouteGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     */
    public function getByAutomaticCost(RouteGetByAutomaticCostRequest $request): RouteGetByAutomaticCostResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        try {
            $functionName .= Utils::createQueryParams($request->toArray());
            $response = $this->sapRequestHelper->request('GET', $functionName, '');

            $responseArray = json_decode($response, true);

            $amount = $responseArray['TRouteResponse'][0]['AMOUNT'];
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return new RouteGetByAutomaticCostResponse(is_numeric($amount) ? floatval($amount) : $amount);
    }

    /**
     * @inheritDoc
     */
    public function store(Route $route): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        try {
            $body = json_encode($route->toArray());

            $response = $this->genericSave('POST', $functionName, $body);

            return $response;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     */
    public function update(Route $route): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $route->getId();

        try {
            $body = json_encode($route->toArray());

            $response = $this->genericSave('PATCH', $functionName, $body);

            return $response;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $response = $this->sapRequestHelper->request('DELETE', $functionName, "");
            $responseArray = json_decode($response, true);

            return boolval($responseArray['SUCCESS']);
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    final private function arrayToRoute(array $routeArray)
    {
        return Route::createFromArray($routeArray);
    }
}
