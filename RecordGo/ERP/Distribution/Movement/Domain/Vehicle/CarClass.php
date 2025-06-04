<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\Vehicle;

class CarClass
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(?int $id, ?string $name = null, ?string $acrissLetter = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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
     * @param array|null $carClassArray
     * @return CarClass
     */
    public static function createFromArray(?array $carClassArray): CarClass
    {
        return new self(
            intval($carClassArray['ID']),
            $carClassArray['CARCLASSNAME']
        );
    }
}
