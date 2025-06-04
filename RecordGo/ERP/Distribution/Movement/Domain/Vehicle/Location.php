<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\Vehicle;

class Location
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
     * @param int $id
     * @param string|null $name
     */
    public function __construct(
        int $id,
        ?string $name = null
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param array|null $locationArray
     * @return Location
     */
    public static function createFromArray(?array $locationArray): Location
    {
        return new self(
            intval($locationArray['ID']),
            $locationArray['LOCATIONNAME']
        );
    }
}
