<?php

declare(strict_types=1);

namespace Distribution\Planning\Domain;


class CommercialGroup
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
     * @param int $id
     * @param string|null $name
     */
    public function __construct(
        ?int $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    final public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    final public function getName(): string
    {
        return $this->name;
    }

}
