<?php
declare(strict_types=1);


namespace Distribution\CarBodyType\Domain;


use Shared\Domain\GetByResponse;
/**
 * Class BusinessUnitArticleGetByResponse
 * @method  CarBodyTypeCollection getCollection()
 */
class CarBodyTypeGetByResponse extends GetByResponse
{
    /**
     * BusinessUnitArticleGetByResponse constructor.
     * @param CarBodyTypeCollection $collection
     * @param int $totalRows
     */
    public function __construct(CarBodyTypeCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}