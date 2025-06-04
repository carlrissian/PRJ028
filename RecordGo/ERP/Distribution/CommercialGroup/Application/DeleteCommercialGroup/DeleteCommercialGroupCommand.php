<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\DeleteCommercialGroup;

class DeleteCommercialGroupCommand
{
    /**
     * @var int
     */
    private int $id;

    /**
     * ActivateCommercialGroupCommand constructor.
     * 
     * @param int $id
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
