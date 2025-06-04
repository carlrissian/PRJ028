<?php

declare(strict_types=1);

namespace Distribution\PurchaseMethod\Domain;

use Shared\Domain\Collection;

/**
 * Class PurchaseMethodCollection
 * @method PurchaseMethod[] getIterator()
 */
class PurchaseMethodCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return PurchaseMethod::class;
    }
}
