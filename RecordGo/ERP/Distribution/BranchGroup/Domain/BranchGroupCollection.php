<?php

declare(strict_types=1);

namespace Distribution\BranchGroup\Domain;


use Shared\Domain\Collection;

class BranchGroupCollection extends Collection
{
    protected function type(): string
    {
        return BranchGroup::class;
    }
}
