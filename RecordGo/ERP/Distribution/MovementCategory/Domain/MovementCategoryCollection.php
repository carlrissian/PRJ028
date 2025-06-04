<?php
declare(strict_types=1);


namespace Distribution\MovementCategory\Domain;


use Shared\Domain\Collection;
/**
 * Class MovementCategoryCollection
 * @method MovementCategory[] getIterator()
 */
class MovementCategoryCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return MovementCategory::class;
    }
}