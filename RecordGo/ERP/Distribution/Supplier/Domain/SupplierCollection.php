<?php
declare(strict_types=1);


namespace Distribution\Supplier\Domain;


use Shared\Domain\Collection;
/**
 * Class SupplierCollection
 * @method Supplier[] getIterator()
 */
class SupplierCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return Supplier::class;
    }
}