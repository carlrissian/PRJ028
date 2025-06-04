<?php
declare(strict_types=1);

namespace Distribution\Department\Domain;

use Shared\Domain\Collection;
/**
 * Class DepartmentCollection
 * @method Department[] getIterator()
 */
class DepartmentCollection extends Collection
{

    protected function type(): string
    {
        return Department::class;
    }
}