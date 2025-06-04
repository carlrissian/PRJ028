<?php

declare(strict_types=1);

namespace Distribution\AcrissImageLine\Domain;

use Shared\Utils\DataValidation;

final class AcrissImageLine
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var integer
     */
    private int $acrissBranchId;

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
     * AcrissImageLine constructor
     *
     * @param int|null $id
     * @param integer $acrissBranchId
     * @param string $url
     * @param string $description
     * @param boolean $byDefault
     */
    public function __construct(
        ?int $id,
        int $acrissBranchId,
        string $url,
        string $description,
        bool $byDefault
    ) {
        $this->id = $id;
        $this->acrissBranchId = $acrissBranchId;
        $this->url = $url;
        $this->description = $description;
        $this->byDefault = $byDefault;
    }

    /**
     * Get the value of id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of acrissBranchId
     *
     * @return integer
     */
    public function getAcrissBranchId(): int
    {
        return $this->acrissBranchId;
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


    /**
     * @param array|null $acrissImageLineArray
     * @return AcrissImageLine
     */
    public static function createFromArray(?array $acrissImageLineArray): AcrissImageLine
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($acrissImageLineArray, 'ID')),
            $helper->intOrNull($helper->arrayExistOrNull($acrissImageLineArray, 'ACRISSBRANCHID')),
            $helper->arrayExistOrNull($acrissImageLineArray, 'ACRISSIMGURL'),
            $helper->arrayExistOrNull($acrissImageLineArray, 'DESCRIPTION'),
            $helper->boolOrNull($helper->arrayExistOrNull($acrissImageLineArray, 'BYDEFAULT'))
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'ACRISSBRANCHID' => $this->getAcrissBranchId(),
            'ACRISSIMGURL' => $this->getUrl(),
            'DESCRIPTION' => $this->getDescription(),
            'ISDEFAULT' => $this->isByDefault(),
        ];
    }
}
