<?php
declare(strict_types=1);


namespace Distribution\BusinessUnitArticle\Domain;


use Shared\Domain\Collection;
/**
 * Class BusinessUnitArticleCollection
 * @method BusinessUnitArticle[] getIterator()
 */


class BusinessUnitArticleCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return BusinessUnitArticle::class;
    }
}