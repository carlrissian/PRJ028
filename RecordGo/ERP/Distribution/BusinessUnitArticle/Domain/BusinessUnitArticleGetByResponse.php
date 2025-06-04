<?php
declare(strict_types=1);


namespace Distribution\BusinessUnitArticle\Domain;


use Shared\Domain\GetByResponse;
/**
 * Class BusinessUnitArticleGetByResponse
 * @method  BusinessUnitArticleCollection getCollection()
 */
class BusinessUnitArticleGetByResponse extends GetByResponse
{
    /**
     * BusinessUnitArticleGetByResponse constructor.
     * @param BusinessUnitArticleCollection $collection
     * @param int $totalRows
     */
    public function __construct(BusinessUnitArticleCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}