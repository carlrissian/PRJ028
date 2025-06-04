<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

class MovementStatus
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
     * MovementStatus constructor.
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
     * @param array $movementStatusArray
     * @return self
     */
    public static function createFromArray(array $movementStatusArray): self
    {
        return new self(
            intval($movementStatusArray['ID']),
            $movementStatusArray['TRANSPORTSTATUS'] ?? null
        );
    }
}
