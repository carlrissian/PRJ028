<?php
declare(strict_types=1);

namespace Distribution\CommercialGroupTranslations\Application\DeleteCommercialGroupTranslations;

class DeleteCommercialGroupTranslationsCommand
{
    private int $id;

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