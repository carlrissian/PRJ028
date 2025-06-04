<?php

namespace Distribution\Route\Application\ProcessFileRoute;

use SplFileInfo;

class ProcessFileRouteCommand
{
    /**
     * @var SplFileInfo
     */
    private SplFileInfo $file;

    /**
     * ProcessFileRouteCommand constructor.
     * 
     * @param SplFileInfo $file
     */
    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
    }

    /**
     * @return SplFileInfo
     */
    public function getFile(): SplFileInfo
    {
        return $this->file;
    }
}
