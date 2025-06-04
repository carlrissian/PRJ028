<?php

declare(strict_types=1);

namespace Distribution\Area\Domain;

use Distribution\Region\Domain\Region;
use JsonSerializable;
use Shared\Utils\DataValidation;

class Area implements JsonSerializable
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var Region|null
     */
    private ?Region $region;

    /**
     * @param int $id
     * @param string|null $name
     * @param Region|null $region
     */
    public function __construct(
        int $id,
        ?string $name = null,
        ?Region $region = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->region = $region;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return Region|null
     */
    public function getRegion(): ?Region
    {
        return $this->region;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }


    /**
     * @param array|null $areaArray
     * @return Area
     */
    public static function createFromArray(?array $areaArray): Area
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($areaArray, 'ID')),
            $helper->arrayExistOrNull($areaArray, 'AREANAME'),
            (isset($areaArray['Region'])) ? Region::createFromArray($areaArray['Region']) : null
        );
    }
}
