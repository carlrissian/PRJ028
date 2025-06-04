<?php

namespace Distribution\Damage\Domain;

use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateValueObject;
use Shared\Domain\ValueObject\DateTimeValueObject;

class Damage
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var TypeZone
     */
    private $typeZone;

    /**
     * @var integer
     */
    private $zone;

    /**
     * @var integer
     */
    private $subZone;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var int|null
     */
    private $raHeadId;

    /**
     * @var boolean
     */
    private $repaired;

    /**
     * @var DateValueObject|null
     */
    private $reparationDate;

    /**
     * @var int|null
     */
    private $repairOrderId;

    /**
     * @var DateTimeValueObject
     */
    private $creationDate;


    /**
     * @param int $id
     * @param TypeZone $typeZone
     * @param integer $zone
     * @param integer $subZone
     * @param string|null $name
     * @param int|null $raHeadId
     * @param bool $repaired
     * @param DateValueObject|null $reparationDate
     * @param int|null $repairOrderId
     * @param DateTimeValueObject $creationDate
     */
    public function __construct(
        int $id,
        TypeZone $typeZone,
        int $zone,
        int $subZone,
        ?string $name,
        ?int $raHeadId,
        bool $repaired,
        ?DateValueObject $reparationDate,
        ?int $repairOrderId,
        DateTimeValueObject $creationDate
    ) {
        $this->id = $id;
        $this->typeZone = $typeZone;
        $this->zone = $zone;
        $this->subZone = $subZone;
        $this->name = $name;
        $this->raHeadId = $raHeadId;
        $this->repaired = $repaired;
        $this->reparationDate = $reparationDate;
        $this->repairOrderId = $repairOrderId;
        $this->creationDate = $creationDate;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return TypeZone
     */
    public function getTypeZone(): TypeZone
    {
        return $this->typeZone;
    }

    /**
     * @return integer
     */
    public function getZone(): int
    {
        return $this->zone;
    }

    /**
     * @return integer
     */
    public function getSubZone(): int
    {
        return $this->subZone;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getRaHeadId(): ?int
    {
        return $this->raHeadId;
    }

    /**
     * @return bool
     */
    public function isRepaired(): bool
    {
        return $this->repaired;
    }

    /**
     * @return DateValueObject|null
     */
    public function getReparationDate(): ?DateValueObject
    {
        return $this->reparationDate;
    }

    /**
     * @return int|null
     */
    public function getRepairOrderId(): ?int
    {
        return $this->repairOrderId;
    }

    /**
     * @return DateTimeValueObject
     */
    public function getCreationDate(): DateTimeValueObject
    {
        return $this->creationDate;
    }


    /**
     * @param array|null $damageArray
     * @return self
     */
    public static function createFromArray(?array $damageArray): self
    {
        return new self(
            intval($damageArray['ID']),
            (isset($damageArray['damageList']['TYPEZONE'])) ? TypeZone::createFromArray($damageArray['damageList']['TYPEZONE']) : null,
            intval($damageArray['damageList']['DAMAGEZONE']),
            intval($damageArray['damageList']['DAMAGESUBZONE']),
            $damageArray['damageList']['NAMETRANS'] ?? null,
            (isset($damageArray['RAHEADID'])) ? intval($damageArray['RAHEADID']) : null,
            intval($damageArray['REPAIRED']) == 1,
            (isset($damageArray['REPAIREDDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($damageArray['REPAIREDDATE'])) : null,
            (isset($damageArray['REPAIRORDERID'])) ? intval($damageArray['REPAIRORDERID']) : null,
            (isset($damageArray['CREATIONDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($damageArray['CREATIONDATE'])) : null
        );
    }
}
