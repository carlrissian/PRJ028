<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\Vehicle;


class SaleMethod
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * SaleMethod constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param array|null $saleMethodArray
     * @return self
     */
    public static function createFromArray(?array $saleMethodArray): self
    {
        return new self(
            intval($saleMethodArray['ID']),
            $saleMethodArray['PURCHASEMETHODNAME']
        );
    }
}
