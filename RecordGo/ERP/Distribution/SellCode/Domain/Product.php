<?php

namespace Distribution\SellCode\Domain;

class Product
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $internalName;

    /**
     * @var string|null
     */
    private $codeName;

    /**
     * Product constructor.
     * 
     * @param int $id
     * @param string|null $internalName
     * @param string|null $codeName
     */
    public function __construct(int $id, ?string $internalName = null, ?string $codeName = null)
    {
        $this->id = $id;
        $this->internalName = $internalName;
        $this->codeName = $codeName;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getInternalName(): ?string
    {
        return $this->internalName;
    }

    /**
     * @return string|null
     */
    public function getCodeName(): ?string
    {
        return $this->codeName;
    }


    /**
     * @param array $productArray
     * @return self
     */
    public static function createFromArray(array $productArray): self
    {
        return new self(
            intval($productArray['PRODUCTID']),
            isset($productArray['ITEMPRODUCT']) ? $productArray['ITEMPRODUCT']['PRODUCTINTREF'] : null,
            isset($productArray['ITEMPRODUCT']) ? $productArray['ITEMPRODUCT']['CODENAME'] : null,
        );
    }
}
