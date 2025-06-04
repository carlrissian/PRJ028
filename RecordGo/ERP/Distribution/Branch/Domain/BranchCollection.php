<?php
declare(strict_types=1);


namespace Distribution\Branch\Domain;


use Shared\Domain\Collection;

class BranchCollection extends Collection
{
    protected function type(): string
    {
        return Branch::class;
    }
}