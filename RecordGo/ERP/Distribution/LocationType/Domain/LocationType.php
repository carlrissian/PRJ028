<?php

declare(strict_types=1);

namespace Distribution\LocationType\Domain;

class LocationType
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $name;

    /**
     * LocationType constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param array|null $locationTypeArray
     * @return LocationType
     */
    public static function createFromArray(?array $locationTypeArray): LocationType
    {
        return new self(
            intval($locationTypeArray['ID']),
            $locationTypeArray['LOCATIONTYPENAME']
        );
    }
    final public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'LOCATIONTYPENAME' => $this->getName()
        ];
    }
}
