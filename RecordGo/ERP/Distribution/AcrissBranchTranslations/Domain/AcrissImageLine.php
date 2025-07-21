<?php

namespace Distribution\AcrissBranchTranslations\Domain;

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
     * @var bool|null
     */
    private ?bool $byDefault;

    /**
     * @param int|null $id
     * @param string $url
     * @param string $description
     * @param bool|null $byDefault
     */
    private function __construct(
        ?int $id,
        string $url,
        string $description,
        ?bool $byDefault
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
     * @return bool|null
     */
    public function isByDefault(): ?bool
    {
        return $this->byDefault;
    }


    /**
     * @param int|null $id
     * @param string $url
     * @param string $description
     * @param bool|null $byDefault
     */
    public static function create(
        ?int $id,
        string $url,
        string $description,
        ?bool $byDefault = null
    ): self {
        return new self(
            $id,
            $url,
            $description,
            $byDefault
        );
    }

    /**
     * @param array|null $acrissImageLineArray
     * @return self
     */
    public static function createFromArray(?array $acrissImageLineArray): self
    {
        return self::create(
            intval($acrissImageLineArray['ID']),
            $acrissImageLineArray['ACRISSIMGURL'] ?? null,
            $acrissImageLineArray['DESCRIPTION'] ?? null,
            isset($acrissImageLineArray['BYDEFAULT']) ? filter_var($acrissImageLineArray['BYDEFAULT'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null
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
