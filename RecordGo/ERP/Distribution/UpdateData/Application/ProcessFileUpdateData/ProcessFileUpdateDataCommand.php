<?php

declare(strict_types=1);

namespace Distribution\UpdateData\Application\ProcessFileUpdateData;

use SplFileInfo;

class ProcessFileUpdateDataCommand
{
    /**
     * @var SplFileInfo
     */
    private SplFileInfo $file;

    /**
     * ProcessFileUpdateDataCommand constructor.
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
