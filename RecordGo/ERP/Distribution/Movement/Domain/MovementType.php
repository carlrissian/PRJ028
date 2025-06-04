<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

class MovementType
{
    const DRIVER = 1;
    const CARRIER = 2;
    const OPERATION = 3;

    /**
     * @var int
     */
    private int $id;
    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * MovementType constructor.
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
