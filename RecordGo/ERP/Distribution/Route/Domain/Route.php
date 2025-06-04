<?php

declare(strict_types=1);

namespace Distribution\Route\Domain;

class Route
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var TransportMethod
     */
    private TransportMethod $transportMethod;

    /**
     * @var Supplier
     */
    private Supplier $provider;

    /**
     * @var Branch
     */
    private Branch $originBranch;

    /**
     * @var Branch
     */
    private Branch $destinationBranch;

    /**
     * @var float|null
     */
    private ?float $fullTruckLoadAmount;

    /**
     * @var float|null
     */
    private ?float $vehicleAmount1;

    /**
     * @var float|null
     */
    private ?float $vehicleAmount2;

    /**
     * @var float|null
     */
    private ?float $vehicleAmount3;

    /**
     * @var float|null
     */
    private ?float $vehicleAmount4;

    /**
     * @var float|null
     */
    private ?float $vehicleAmount5;

    /**
     * @var float|null
     */
    private ?float $vehicleAmount6;

    /**
     * @var float|null
     */
    private ?float $vehicleAmount7;

    /**
     * @var float|null
     */
    private ?float $vehicleAmount8;

    /**
     * @var float|null
     */
    private ?float $vehicleAmount9;

    /**
     * @var float|null
     */
    private ?float $vehicleAmount10;

    /**
     * @var float|null
     */
    private ?float $suvLoadAmount;

    /**
     * @var float|null
     */
    private ?float $vanLoadAmount;


    public function __construct(
        ?int $id,
        TransportMethod $transportMethod,
        Supplier $provider,
        Branch $originBranch,
        Branch $destinationBranch,
        ?float $fullTruckLoadAmount,
        ?float $vehicleAmount1,
        ?float $vehicleAmount2,
        ?float $vehicleAmount3,
        ?float $vehicleAmount4,
        ?float $vehicleAmount5,
        ?float $vehicleAmount6,
        ?float $vehicleAmount7,
        ?float $vehicleAmount8,
        ?float $vehicleAmount9,
        ?float $vehicleAmount10,
        ?float $suvLoadAmount,
        ?float $vanLoadAmount
    ) {
        $this->id = $id;
        $this->transportMethod = $transportMethod;
        $this->provider = $provider;
        $this->originBranch = $originBranch;
        $this->destinationBranch = $destinationBranch;
        $this->fullTruckLoadAmount = $fullTruckLoadAmount;
        $this->vehicleAmount1 = $vehicleAmount1;
        $this->vehicleAmount2 = $vehicleAmount2;
        $this->vehicleAmount3 = $vehicleAmount3;
        $this->vehicleAmount4 = $vehicleAmount4;
        $this->vehicleAmount5 = $vehicleAmount5;
        $this->vehicleAmount6 = $vehicleAmount6;
        $this->vehicleAmount7 = $vehicleAmount7;
        $this->vehicleAmount8 = $vehicleAmount8;
        $this->vehicleAmount9 = $vehicleAmount9;
        $this->vehicleAmount10 = $vehicleAmount10;
        $this->suvLoadAmount = $suvLoadAmount;;
        $this->vanLoadAmount = $vanLoadAmount;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return TransportMethod
     */
    public function getTransportMethod(): TransportMethod
    {
        return $this->transportMethod;
    }

    /**
     * @return Supplier
     */
    public function getProvider(): Supplier
    {
        return $this->provider;
    }

    /**
     * @return Branch
     */
    public function getOriginBranch(): Branch
    {
        return $this->originBranch;
    }

    /**
     * @return Branch
     */
    public function getDestinationBranch(): Branch
    {
        return $this->destinationBranch;
    }

    /**
     * @return float|null
     */
    public function getFullTruckLoadAmount(): ?float
    {
        return $this->fullTruckLoadAmount;
    }

    /**
     * @param float|null $fullTruckLoadAmount
     */
    public function setFullTruckLoadAmount($fullTruckLoadAmount)
    {
        $this->fullTruckLoadAmount = $fullTruckLoadAmount;
    }

    /**
     * @return float|null
     */
    public function getVehicleAmount1(): ?float
    {
        return $this->vehicleAmount1;
    }

    /**
     * @param float|null $vehicleAmount1
     */
    public function setVehicleAmount1($vehicleAmount1)
    {
        $this->vehicleAmount1 = $vehicleAmount1;
    }

    /**
     * @return float|null
     */
    public function getVehicleAmount2(): ?float
    {
        return $this->vehicleAmount2;
    }

    /**
     * @param float|null $vehicleAmount2
     */
    public function setVehicleAmount2($vehicleAmount2)
    {
        $this->vehicleAmount2 = $vehicleAmount2;
    }

    /**
     * @return float|null
     */
    public function getVehicleAmount3(): ?float
    {
        return $this->vehicleAmount3;
    }

    /**
     * @param float|null $vehicleAmount3
     */
    public function setVehicleAmount3($vehicleAmount3)
    {
        $this->vehicleAmount3 = $vehicleAmount3;
    }

    /**
     * @return float|null
     */
    public function getVehicleAmount4(): ?float
    {
        return $this->vehicleAmount4;
    }

    /**
     * @param float|null $vehicleAmount4
     */
    public function setVehicleAmount4($vehicleAmount4)
    {
        $this->vehicleAmount4 = $vehicleAmount4;
    }

    /**
     * @return float|null
     */
    public function getVehicleAmount5(): ?float
    {
        return $this->vehicleAmount5;
    }

    /**
     * @param float|null $vehicleAmount5
     */
    public function setVehicleAmount5($vehicleAmount5)
    {
        $this->vehicleAmount5 = $vehicleAmount5;
    }

    /**
     * @return float|null
     */
    public function getVehicleAmount6(): ?float
    {
        return $this->vehicleAmount6;
    }

    /**
     * @param float|null $vehicleAmount6
     */
    public function setVehicleAmount6($vehicleAmount6)
    {
        $this->vehicleAmount6 = $vehicleAmount6;
    }

    /**
     * @return float|null
     */
    public function getVehicleAmount7(): ?float
    {
        return $this->vehicleAmount7;
    }

    /**
     * @param float|null $vehicleAmount7
     */
    public function setVehicleAmount7($vehicleAmount7)
    {
        $this->vehicleAmount7 = $vehicleAmount7;
    }

    /**
     * @return float|null
     */
    public function getVehicleAmount8(): ?float
    {
        return $this->vehicleAmount8;
    }

    /**
     * @param float|null $vehicleAmount8
     */
    public function setVehicleAmount8($vehicleAmount8)
    {
        $this->vehicleAmount8 = $vehicleAmount8;
    }

    /**
     * @return float|null
     */
    public function getVehicleAmount9(): ?float
    {
        return $this->vehicleAmount9;
    }

    /**
     * @param float|null $vehicleAmount9
     */
    public function setVehicleAmount9($vehicleAmount9)
    {
        $this->vehicleAmount9 = $vehicleAmount9;
    }

    /**
     * @return float|null
     */
    public function getVehicleAmount10(): ?float
    {
        return $this->vehicleAmount10;
    }

    /**
     * @param float|null $vehicleAmount10
     */
    public function setVehicleAmount10($vehicleAmount10)
    {
        $this->vehicleAmount10 = $vehicleAmount10;
    }

    /**
     * @return float|null
     */
    public function getSUVLoadAmount(): ?float
    {
        return $this->suvLoadAmount;
    }

    /**
     * @param float|null $suvLoadAmount
     */
    public function setSuvLoadAmount($suvLoadAmount)
    {
        $this->suvLoadAmount = $suvLoadAmount;
    }

    /**
     * @return float|null
     */
    public function getVanLoadAmount(): ?float
    {
        return $this->vanLoadAmount;
    }

    /**
     * @param float|null $vanLoadAmount
     */
    public function setVanLoadAmount($vanLoadAmount)
    {
        $this->vanLoadAmount = $vanLoadAmount;
    }


    /**
     * @param array $routeArray
     * @return self
     */
    public static function createFromArray(array $routeArray): self
    {
        return new self(
            intval($routeArray['ID']),
            // TransportMethod::createFromArray($routeArray['TRANSPORTMETHOD']),
            TransportMethod::createFromArray($routeArray['TransportMethodId']),
            // Supplier::createFromArray($routeArray['TRANSPORTPROVIDER']),
            Supplier::createFromArray($routeArray['TRANSPORTPROVIDERID']),
            // Branch::createFromArray($routeArray['BRANCHORIGIN']),
            Branch::createFromArray($routeArray['BRANCHORIGINID']),
            // Branch::createFromArray($routeArray['BRANCHDESTINY']),
            Branch::createFromArray($routeArray['BRANCHDESTINYID']),
            (isset($routeArray['COMPLETELOADAMOUNT']) && is_numeric($routeArray['COMPLETELOADAMOUNT'])) ? floatval($routeArray['COMPLETELOADAMOUNT']) : null,
            (isset($routeArray['VEHICLEAMOUNT1']) && is_numeric($routeArray['VEHICLEAMOUNT1'])) ? floatval($routeArray['VEHICLEAMOUNT1']) : null,
            (isset($routeArray['VEHICLEAMOUNT2']) && is_numeric($routeArray['VEHICLEAMOUNT2'])) ? floatval($routeArray['VEHICLEAMOUNT2']) : null,
            (isset($routeArray['VEHICLEAMOUNT3']) && is_numeric($routeArray['VEHICLEAMOUNT3'])) ? floatval($routeArray['VEHICLEAMOUNT3']) : null,
            (isset($routeArray['VEHICLEAMOUNT4']) && is_numeric($routeArray['VEHICLEAMOUNT4'])) ? floatval($routeArray['VEHICLEAMOUNT4']) : null,
            (isset($routeArray['VEHICLEAMOUNT5']) && is_numeric($routeArray['VEHICLEAMOUNT5'])) ? floatval($routeArray['VEHICLEAMOUNT5']) : null,
            (isset($routeArray['VEHICLEAMOUNT6']) && is_numeric($routeArray['VEHICLEAMOUNT6'])) ? floatval($routeArray['VEHICLEAMOUNT6']) : null,
            (isset($routeArray['VEHICLEAMOUNT7']) && is_numeric($routeArray['VEHICLEAMOUNT7'])) ? floatval($routeArray['VEHICLEAMOUNT7']) : null,
            (isset($routeArray['VEHICLEAMOUNT8']) && is_numeric($routeArray['VEHICLEAMOUNT8'])) ? floatval($routeArray['VEHICLEAMOUNT8']) : null,
            (isset($routeArray['VEHICLEAMOUNT9']) && is_numeric($routeArray['VEHICLEAMOUNT9'])) ? floatval($routeArray['VEHICLEAMOUNT9']) : null,
            (isset($routeArray['VEHICLEAMOUNT10']) && is_numeric($routeArray['VEHICLEAMOUNT10'])) ? floatval($routeArray['VEHICLEAMOUNT10']) : null,
            (isset($routeArray['SUVLOADAMOUNT']) && is_numeric($routeArray['SUVLOADAMOUNT'])) ? floatval($routeArray['SUVLOADAMOUNT']) : null,
            (isset($routeArray['VANLOADAMOUNT']) && is_numeric($routeArray['VANLOADAMOUNT'])) ? floatval($routeArray['VANLOADAMOUNT']) : null
        );
    }

    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'TRANSPORTMETHODID' => $this->getTransportMethod()->getId(),
            'TRANSPORTPROVIDERID' => $this->getProvider()->getId(),
            'BRANCHORIGINID' => $this->getOriginBranch()->getId(),
            'BRANCHDESTINYID' => $this->getDestinationBranch()->getId(),
            'COMPLETELOADAMOUNT' => $this->getFullTruckLoadAmount(),
            'VEHICLEAMOUNT1' => $this->getVehicleAmount1(),
            'VEHICLEAMOUNT2' => $this->getVehicleAmount2(),
            'VEHICLEAMOUNT3' => $this->getVehicleAmount3(),
            'VEHICLEAMOUNT4' => $this->getVehicleAmount4(),
            'VEHICLEAMOUNT5' => $this->getVehicleAmount5(),
            'VEHICLEAMOUNT6' => $this->getVehicleAmount6(),
            'VEHICLEAMOUNT7' => $this->getVehicleAmount7(),
            'VEHICLEAMOUNT8' => $this->getVehicleAmount8(),
            'VEHICLEAMOUNT9' => $this->getVehicleAmount9(),
            'VEHICLEAMOUNT10' => $this->getVehicleAmount10(),
            'SUVLOADAMOUNT' => $this->getsuvLoadAmount(),
            'VANLOADAMOUNT' => $this->getVanLoadAmount(),
        ];
    }
}
