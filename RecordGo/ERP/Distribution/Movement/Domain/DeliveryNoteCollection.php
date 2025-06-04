<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


use Shared\Domain\Collection;
/**
 * Class DeliveryNoteCollection
 * @method DeliveryNote[] getIterator()
 */
class DeliveryNoteCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return DeliveryNote::class;
    }
}