<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\Vehicle;


class Region
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
    public function __construct(int $id, ?string $name = null)
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array|null $regionArray
     * @return Region
     */
    public static function createFromArray(?array $regionArray): Region
    {
        return new self(
            intval($regionArray['ID']),
           $regionArray['REGIONNAME']
        );
    }
}
