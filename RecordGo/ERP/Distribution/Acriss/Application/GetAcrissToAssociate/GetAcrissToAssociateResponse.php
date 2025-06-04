<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\GetAcrissToAssociate;


use Distribution\Acriss\Domain\AcrissCollection;
use Shared\Domain\GetByResponse;


class GetAcrissToAssociateResponse extends GetByResponse
{
     /**
     * GetAcrissQueryHandlerResponse constructor.
     * @param AcrissCollection $collection
     * @param int $totalRows
     */
    public function __construct(AcrissCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}