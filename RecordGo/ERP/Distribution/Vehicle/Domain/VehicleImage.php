<?php

namespace Distribution\Vehicle\Domain;

class VehicleImage
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var boolean|null
     */
    private $byDefault;

    /**
     * @param int $id
     * @param string $url
     * @param bool $byDefault
     */
    public function __construct(
        int $id,
        string $url,
        ?bool $byDefault = false
    ) {
        $this->id = $id;
        $this->url = $url;
        $this->byDefault = $byDefault;
    }

    /**
     * @return int
     */
    public function getId(): int
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
     * @return bool
     */
    public function isByDefault(): ?bool
    {
        return $this->byDefault;
    }


    /**
     * @param array|null $vehicleImageArray
     * @return self
     */
    public static function createFromArray(?array $vehicleImageArray): self
    {
        return new self(
            intval($vehicleImageArray['ID']),
            $vehicleImageArray['VEHICLEIMG'] ?? null,
            filter_var($vehicleImageArray['BYDEFAULT'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
        );
    }
}
