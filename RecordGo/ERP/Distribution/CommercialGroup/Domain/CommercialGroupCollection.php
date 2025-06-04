<?php
declare(strict_types=1);

namespace Distribution\CommercialGroup\Domain;

use Shared\Domain\Collection;

/**
 * Class CommercialGroupCollection
 * @method CommercialGroup[] getIterator()
 */
class CommercialGroupCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return CommercialGroup::class;
    }
}
