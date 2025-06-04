<?php
declare(strict_types=1);


namespace Distribution\BusinessUnitArticle\Domain;


use Shared\Domain\Collection;
/**
 * Class MovementTypeCollection
 * @method MovementType[] getIterator()
 */
class MovementTypeCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return MovementType::class;
    }
}