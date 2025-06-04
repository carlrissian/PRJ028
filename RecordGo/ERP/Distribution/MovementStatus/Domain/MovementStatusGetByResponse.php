<?php
declare(strict_types=1);


namespace Distribution\MovementStatus\Domain;


use Shared\Domain\GetByResponse;
/**
 * Class MovementStatusGetByResponse
 * @method MovementStatusCollection getCollection()
 */
class MovementStatusGetByResponse extends GetByResponse
{
    /**
     * MovementStatusGetByResponse constructor.
     * @param MovementStatusCollection $collection
     * @param int $totalRows
     */
    public function __construct(MovementStatusCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}