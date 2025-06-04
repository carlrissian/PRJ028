<?php
declare(strict_types=1);


namespace Distribution\SupplierContact\Domain;


use Shared\Domain\Collection;

class SupplierContactCollection extends Collection
{
    protected function type(): string
    {
        return SupplierContact::class;
    }
}