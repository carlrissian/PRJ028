<?php
declare(strict_types=1);


namespace Distribution\TransportMethod\Domain;


use Shared\Domain\Collection;
/**
 * Class TransportMethodCollection
 * @method TransportMethod[] getIterator()
 */
class TransportMethodCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return TransportMethod::class;
    }

}