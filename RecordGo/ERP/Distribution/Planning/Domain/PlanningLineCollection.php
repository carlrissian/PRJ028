<?php
declare(strict_types=1);


namespace Distribution\Planning\Domain;


use Shared\Domain\Collection;
/**
 * Class PlanningLineCollection
 * @method PlanningLine[] getIterator()
 */
class PlanningLineCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return PlanningLine::class;
    }
}