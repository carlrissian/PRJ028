<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


use Shared\Domain\Collection;

/**
 * Class MovementCollection
 * @method Movement[] getIterator()
 */
class MovementCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return Movement::class;
    }
}