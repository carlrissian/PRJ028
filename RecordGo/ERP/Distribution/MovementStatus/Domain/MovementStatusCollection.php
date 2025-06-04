<?php
declare(strict_types=1);


namespace Distribution\MovementStatus\Domain;


use Shared\Domain\Collection;
/**
 * Class MovementStatusCollection
 * @method MovementStatus[] getIterator()
 */
class MovementStatusCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return MovementStatus::class;
    }
}