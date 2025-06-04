<?php

namespace Distribution\Product\Domain;

class Product
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var string
     */
    private $codeName;

    /**
     * @var string
     */
    private $internalName;

    /**
     * Product constructor.
     *
     * @param int|null $id
     * @param int|null $version
     * @param string $codeName
     * @param string $internalName
     */
    public function __construct(
        ?int $id,
        ?int $version,
        string $codeName,
        string $internalName
    ) {
        $this->id = $id;
        $this->version = $version;
        $this->codeName = $codeName;
        $this->internalName = $internalName;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getCodeName(): string
    {
        return $this->codeName;
    }

    /**
     * @return string
     */
    public function getInternalName(): string
    {
        return $this->internalName;
    }


    /**
     * @param array $productArray
     * @return self
     */
    public static function createFromArray(array $productArray): self
    {
        return new self(
            intval($productArray['ID']),
            isset($productArray['VERSION_ID']) ? intval($productArray['VERSION_ID']) : null,
            $productArray['CODENAME'] ?? null,
            $productArray['PRODUCTINTREF'] ?? null
        );
    }
}
