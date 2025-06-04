<?php
declare(strict_types=1);


namespace Distribution\Maintenance\Domain;


use Shared\Domain\ValueObject\DateValueObject;

class Maintenance
{
    /**
     * @var string
     */
    private string $documentId;
    /**
     * @var DateValueObject
     */
    private DateValueObject $maintenanceEndDate;

    /**
     * @param string $documentId
     * @param DateValueObject $maintenanceEndDate
     */
    public function __construct(string $documentId, DateValueObject $maintenanceEndDate)
    {
        $this->documentId = $documentId;
        $this->maintenanceEndDate = $maintenanceEndDate;
    }

    /**
     * @return string
     */
    public function getDocumentId(): string
    {
        return $this->documentId;
    }

    /**
     * @return DateValueObject
     */
    public function getMaintenanceEndDate(): DateValueObject
    {
        return $this->maintenanceEndDate;
    }

}