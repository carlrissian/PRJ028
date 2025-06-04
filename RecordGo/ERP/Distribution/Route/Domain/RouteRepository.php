<?php

declare(strict_types=1);

namespace Distribution\Route\Domain;

interface RouteRepository
{
    /**
     * @param RouteCriteria $criteria
     * @return RouteGetByResponse
     */
    public function getBy(RouteCriteria $criteria): RouteGetByResponse;

    /**
     * @param RouteGetByAutomaticCostRequest $request
     * @return RouteGetByAutomaticCostResponse
     */
    public function getByAutomaticCost(RouteGetByAutomaticCostRequest $request): RouteGetByAutomaticCostResponse;

    /**
     * @param Route $route
     * @return int
     */
    public function store(Route $route): int;

    /**
     * @param Route $route
     * @return int
     */
    public function update(Route $route): int;

    /**
     * @param Route $route
     * @return bool
     */
    public function delete(int $id): bool;
}
