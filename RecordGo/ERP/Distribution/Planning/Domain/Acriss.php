<?php

declare(strict_types=1);

namespace Distribution\Planning\Domain;

/**
 * Class Acriss
 * @package Distribution\Acriss\Domain
 */
class Acriss
{
    private int $id;
    private ?String $acrissName;


    /**
     * @param int|null $id
     * @param String|null $acrissName
     */
    public function __construct(
        int $id,
        ?String $acrissName = null
    ) {
        $this->id = $id;
        $this->acrissName = $acrissName;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return String|null
     */
    public function getAcrissName(): ?String
    {
        return $this->acrissName;
    }

}
