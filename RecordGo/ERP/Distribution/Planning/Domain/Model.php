<?php

declare(strict_types=1);

namespace Distribution\Planning\Domain;

class Model
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private string $name;
    /**
     * @var int|null
     */
    private ?int $brandId;

    /**
     * Model constructor.
     * 
     * @param int $id
     * @param string|null $name
     * @param int|null $brandId
     */
    public function __construct(int $id, ?string $name = null, ?int $brandId = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->brandId = $brandId;
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
     * @return int|null
     */
    public function getBrandId(): ?int
    {
        return $this->brandId;
    }

}
