<?php
declare(strict_types=1);

namespace Distribution\Acriss\Application\DisassociateAcriss;


class DisassociateAcrissCommand
{
    /**
     * @var int
     */
    private int $acrissId;
    /**
     * @var array
     */
    private array $acrissList;

    /**
     * @param int $acrissId
     * @param array $acrissList
     */
    public function __construct(int $acrissId, array $acrissList)
    {
        $this->acrissId = $acrissId;
        $this->acrissList = $acrissList;
    }

    /**
     * @return int
     */
    public function getAcrissId(): int
    {
        return $this->acrissId;
    }

    /**
     * @return array
     */
    public function getAcrissList(): array
    {
        return $this->acrissList;
    }


}