<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Application\UpdateAcrissBranch;

class UpdateAcrissBranchCommand
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $acrissId;

    /**
     * @var int
     */
    private int $branchId;

    /**
     * @var string
     */
    private string $commercialName;

    /**
     * @var bool
     */
    private bool $byDefault;

    /**
     * @var int
     */
    private int $userId;

    /**
     * @param int $id
     * @param int $acrissId
     * @param int $branchId
     * @param string $commercialName
     * @param bool $byDefault
     * @param int $userId
     */
    public function __construct(
        int $id,
        int $acrissId,
        int $branchId,
        string $commercialName,
        bool $byDefault,
        int $userId
    ) {
        $this->id = $id;
        $this->acrissId = $acrissId;
        $this->branchId = $branchId;
        $this->commercialName = $commercialName;
        $this->byDefault = $byDefault;
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    final public function getAcrissId(): int
    {
        return $this->acrissId;
    }

    /**
     * @return int
     */
    final public function getBranchId(): int
    {
        return $this->branchId;
    }

    /**
     * @return string
     */
    final public function getCommercialName(): string
    {
        return $this->commercialName;
    }

    /**
     * @return bool
     */
    final public function isByDefault(): bool
    {
        return $this->byDefault;
    }

    /**
     * @return int
     */
    final public function getUserId(): int
    {
        return $this->userId;
    }
}
