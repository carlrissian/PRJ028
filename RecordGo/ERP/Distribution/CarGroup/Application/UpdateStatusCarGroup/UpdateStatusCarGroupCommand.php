<?php
declare(strict_types=1);


namespace Distribution\CarGroup\Application\UpdateStatusCarGroup;



class UpdateStatusCarGroupCommand
{

    /**
     * @var int
     */
    private int $carGroupId;
    /**
     * @var bool
     */
    private bool $enabled;

    /**
     * @param int $carGroupId
     * @param bool $enabled
     */
    public function __construct(int $carGroupId, bool $enabled)
    {
        $this->carGroupId = $carGroupId;
        $this->enabled = $enabled;
    }

    /**
     * @return int
     */
    public function getCarGroupId(): int
    {
        return $this->carGroupId;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

}
