<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Domain;

use Shared\Utils\DataValidation;

final class AcrissImageLine
{
    /**
     * @var int|null
     */
    private ?int $id;

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
     * @param int|null $id
     * @param string $url
     * @param string $description
     * @param bool $byDefault
     */
    public function __construct(
        ?int $id,
        string $url,
        string $description,
        bool $byDefault
    ) {
        $this->id = $id;
        $this->url = $url;
        $this->description = $description;
        $this->byDefault = $byDefault;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
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
            'ACRISSIMGURL' => $this->getUrl(),
            'DESCRIPTION' => $this->getDescription(),
            'BYDEFAULT' => $this->isByDefault() ? 1 : 0,
        ];
    }
}
