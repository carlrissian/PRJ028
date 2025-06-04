<?php
declare(strict_types=1);

namespace Distribution\Vehicle\Application\ShowStatusChangeDocType;

class ShowStatusChangeDocTypeQuery
{
    /**
     * @var int
     */
    private int $documentTypeId;
    /**
     * @var int
     */
    private int $vehicleId;
    /**
     * @var int
     */
    private int $documentId;
    /**
     * @var string|null
     */
    private ?string $licensePlate;
    /**
     * @var string|null
     */
    private ?string $actualLoadDate;

    /**
     * @param int $documentTypeId
     * @param int $vehicleId
     * @param int $documentId
     * @param string $licensePlate
     * @param string $actualLoadDate
     */
    public function __construct(int $documentTypeId, int $vehicleId, int $documentId, ?string $licensePlate = null, ?string $actualLoadDate = null)
    {
        $this->documentTypeId = $documentTypeId;
        $this->vehicleId = $vehicleId;
        $this->documentId = $documentId;
        $this->licensePlate = $licensePlate;
        $this->actualLoadDate = $actualLoadDate;
    }

    /**
     * @return int
     */
    public function getDocumentTypeId(): int
    {
        return $this->documentTypeId;
    }

    /**
     * @return int
     */
    public function getVehicleId(): int
    {
        return $this->vehicleId;
    }

    /**
     * @return int
     */
    public function getDocumentId(): int
    {
        return $this->documentId;
    }

    /**
     * @return string|null
     */
    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    /**
     * @return string|null
     */
    public function getActualLoadDate(): ?string
    {
        return $this->actualLoadDate;
    }

}