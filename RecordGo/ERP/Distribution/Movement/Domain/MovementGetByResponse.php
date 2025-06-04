<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


use Shared\Domain\GetByResponse;

/**
 * Class MovementGetByResponse
 * @method MovementCollection getCollection()
 */
class MovementGetByResponse extends GetByResponse
{

    /**
     * MovementGetByResponse constructor.
     * @param MovementCollection $collection
     * @param int $totalRows
     */
    public function __construct(MovementCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}