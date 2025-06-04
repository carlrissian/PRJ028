<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\UpdateStatusAcriss;



class UpdateStatusAcrissCommand
{

    /**
     * @var int
     */
    private int $acrissId;
    /**
     * @var bool
     */
    private bool $enabled;

    /**
     * @param int $acrissId
     * @param bool $enabled
     */
    public function __construct(int $acrissId, bool $enabled)
    {
        $this->acrissId = $acrissId;
        $this->enabled = $enabled;
    }

    /**
     * @return int
     */
    public function getAcrissId(): int
    {
        return $this->acrissId;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

}
