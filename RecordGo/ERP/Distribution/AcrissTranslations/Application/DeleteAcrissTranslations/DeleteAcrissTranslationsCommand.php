<?php

declare(strict_types=1);

namespace Distribution\AcrissTranslations\Application\DeleteAcrissTranslations;

class DeleteAcrissTranslationsCommand
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * constructor.
     * 
     * @param integer $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
