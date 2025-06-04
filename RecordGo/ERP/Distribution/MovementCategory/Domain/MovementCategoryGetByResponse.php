<?php
declare(strict_types=1);


namespace Distribution\MovementCategory\Domain;


use Shared\Domain\GetByResponse;
/**
 * Class MovementCategoryGetByResponse
 * @method MovementCategoryCollection getCollection()
 */
class MovementCategoryGetByResponse extends GetByResponse
{
    /**
     * MovementCategoryGetByResponse constructor.
     * @param MovementCategoryCollection $collection
     * @param int $totalRows
     */
    public function __construct(MovementCategoryCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}