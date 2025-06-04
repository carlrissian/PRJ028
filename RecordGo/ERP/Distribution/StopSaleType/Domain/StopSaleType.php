<?php
declare(strict_types=1);


namespace Distribution\StopSaleType\Domain;


class StopSaleType
{
    /**
     * @var int|null
     */
    private ?int $id;
    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * StopSaleType constructor.
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(?int $id, ?string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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


}