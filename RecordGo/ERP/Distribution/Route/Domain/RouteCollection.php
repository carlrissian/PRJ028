<?php
declare(strict_types=1);


namespace Distribution\Route\Domain;


use Shared\Domain\Collection;
/**
 * Class RouteCollection
 * @method Route[] getIterator()
 */
class RouteCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return Route::class;
    }
}