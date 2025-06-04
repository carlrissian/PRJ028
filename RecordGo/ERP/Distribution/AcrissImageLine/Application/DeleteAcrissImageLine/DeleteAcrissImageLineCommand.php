<?php

declare(strict_types=1);

namespace Distribution\AcrissImageLine\Application\DeleteAcrissImageLine;

class DeleteAcrissImageLineCommand
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * constructor
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
