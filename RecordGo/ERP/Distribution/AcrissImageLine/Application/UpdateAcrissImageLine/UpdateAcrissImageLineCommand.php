<?php

declare(strict_types=1);

namespace Distribution\AcrissImageLine\Application\UpdateAcrissImageLine;

class UpdateAcrissImageLineCommand
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * @var integer
     */
    private int $acrissId;

    /**
     * @var integer
     */
    private int $branchId;

    /**
     * @var string
     */
    private string $url;

    /**
     * @var string
     */
    private string $description;

    /**
     * @var bool
     */
    private bool $byDefault;

    /**
     * constructor
     *
     * @param integer $id
     * @param integer $acrissId
     * @param integer $branchId
     * @param string $url
     * @param string $description
     * @param boolean $byDefault
     */
    public function __construct(
        int $id,
        int $acrissId,
        int $branchId,
        string $url,
        string $description,
        bool $byDefault
    ) {
        $this->id = $id;
        $this->acrissId = $acrissId;
        $this->branchId = $branchId;
        $this->url = $url;
        $this->description = $description;
        $this->byDefault = $byDefault;
    }

    /**
     * Get the value of id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of acrissId
     *
     * @return integer
     */
    public function getAcrissId(): int
    {
        return $this->acrissId;
    }

    /**
     * Get the value of branchId
     *
     * @return integer
     */
    public function getBranchId(): int
    {
        return $this->branchId;
    }

    /**
     * Get the value of url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get the value of description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get the value of byDefault
     *
     * @return bool
     */
    public function isByDefault(): bool
    {
        return $this->byDefault;
    }
}
