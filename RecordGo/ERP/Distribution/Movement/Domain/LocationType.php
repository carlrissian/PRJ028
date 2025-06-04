<?php

namespace Distribution\Movement\Domain;

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
     * @return self|null
     */
    public static function createFromArray(?array $locationTypeArray): ?self
    {
        return (is_array($locationTypeArray)) ? new self(
            intval($locationTypeArray['ID']),
            $locationTypeArray['LOCATIONTYPENAME']
        ) : null;
    }
}
