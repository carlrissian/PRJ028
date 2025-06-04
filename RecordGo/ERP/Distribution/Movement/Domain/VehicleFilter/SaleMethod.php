<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\VehicleFilter;


class SaleMethod
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * SaleMethod constructor.
     * 
     * @param int $id
     * @param string|null $name
     */
    public function __construct(int $id, ?string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
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
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array|null $saleMethodArray
     * @return SaleMethod
     */
    public static function createFromArray(?array $saleMethodArray): SaleMethod
    {
        return new self(
            intval($saleMethodArray['ID']),
            $saleMethodArray['PURCHASEMETHODNAME']
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
        ];
    }
}
