<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\DeleteCommercialGroup;

class DeleteCommercialGroupCommandResponse
{
    /**
     * @var bool
     */
    private $deleted;

    /**
     * constructor
     *
     * @param boolean $deleted
     */
    public function __construct(bool $deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * Get the value of deleted
     *
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }
}
