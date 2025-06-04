<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

class MovementCategory
{
    const ORDINARY = 1;
    const NOT_ORDINARY = 2;
    const INTERNAL = 3;

    /**
     * @var int
     */
    private int $id;
    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * MovementCategory constructor.
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
}
