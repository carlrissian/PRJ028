<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Application\DeleteAcrissBranch;

class DeleteAcrissBranchCommand
{
    /**
     * @var integer
     */
    private int $id;

    /**
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
