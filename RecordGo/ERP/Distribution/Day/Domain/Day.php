<?php
declare(strict_types=1);


namespace Distribution\Day\Domain;


class Day
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
     * Day constructor.
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