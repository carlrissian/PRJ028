<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\Vehicle;


class Area
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
     * @param array|null $areaArray
     * @return Area
     */
    public static function createFromArray(?array $areaArray): Area
    {
        return new self(
            intval($areaArray['ID']),
            $areaArray['AREANAME']
        );
    }
}
