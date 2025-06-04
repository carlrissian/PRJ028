<?php
declare(strict_types=1);

namespace Distribution\Vehicle\Application\ShowStatusChangeDocType;

class ShowStatusChangeDocTypeResponse
{
    private $statusChangeDocType;

    public function __construct($statusChangeDocType)
    {
        $this->statusChangeDocType = $statusChangeDocType;
    }

    /**
     * @return mixed
     */
    public function getStatusChangeDocType()
    {
        return $this->statusChangeDocType;
    }


}