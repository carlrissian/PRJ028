<?php

namespace Distribution\StopSale\Domain;

/**
 * Class Acriss
 * @package Distribution\StopSale\Domain
 */
final class Acriss
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var CarGroup|null
     */
    private ?CarGroup $carGroup;


    /**
     * @param int|null $id
     * @param string|null $name
     */
    private function __construct(
        int $id,
        ?string $name,
        ?CarGroup $carGroup
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->carGroup = $carGroup;
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
     * @return CarGroup|null
     */
    public function getCarGroup(): ?CarGroup
    {
        return $this->carGroup;
    }


    /**
     * @param int|null $id
     * @param string|null $name
     */
    public static function create(
        int $id,
        ?string $name = null,
        ?CarGroup $carGroup = null
    ): self {
        return new self($id, $name, $carGroup);
    }

    /**
     * @param array|null $acrissArray
     * @return self
     */
    public static function createFromArray(?array $acrissArray): self
    {
        return self::create(
            intval($acrissArray['ID']),
            $acrissArray['ACRISSCODE'] ?? null,
            isset($acrissArray['carGroup']) ? CarGroup::createFromArray($acrissArray['carGroup']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
        ];
    }
}
