<?php
declare(strict_types=1);


namespace Distribution\Country\Domain;


use Shared\Domain\Collection;
/**
 * Class CountryCollection
 * @method Country[] getIterator()
 */
class CountryCollection extends Collection
{

    protected function type(): string
    {
        return Country::class;
    }
}