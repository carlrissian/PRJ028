<?php

declare(strict_types=1);

namespace Distribution\Branch\Domain;

use Shared\Utils\DataValidation;

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
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($areaArray, 'ID')),
            $helper->arrayExistOrNull($areaArray, 'AREANAME')
        );
    }
}
