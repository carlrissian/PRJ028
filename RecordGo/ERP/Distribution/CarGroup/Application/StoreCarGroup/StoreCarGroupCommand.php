<?php
declare(strict_types=1);


namespace Distribution\CarGroup\Application\StoreCarGroup;


/**
 * Class StoreCarGroupCommand
 * @package Distribution\CarGroup\Application\StoreCarGroup
 */
class StoreCarGroupCommand
{
    /**
     * @var string
     */
    private string $name;
    /**
     * @var int
     */
    private int $acrissId;


    /**
     * @param string $name
     * @param int $acrissId
     */
    public function __construct(string $name, int $acrissId)
    {
        $this->name = $name;
        $this->acrissId = $acrissId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getAcrissId(): int
    {
        return $this->acrissId;
    }

}