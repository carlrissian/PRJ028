<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\ProcessFileAssignVehicle;

use SplFileInfo;

class ProcessFileAssignVehicleMovementCommand
{
    /**
     * @var int
     */
    private $movementId;

    /**
     * @var SplFileInfo
     */
    private $file;

    public function __construct(int $movementId, SplFileInfo $file)
    {
        $this->movementId = $movementId;
        $this->file = $file;
    }

    /**
     * @return int
     */
    public function getMovementId(): int
    {
        return $this->movementId;
    }

    /**
     * @return SplFileInfo
     */
    public function getFile(): SplFileInfo
    {
        return $this->file;
    }
}
