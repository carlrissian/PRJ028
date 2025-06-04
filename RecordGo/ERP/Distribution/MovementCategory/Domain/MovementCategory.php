<?php

declare(strict_types=1);


namespace Distribution\MovementCategory\Domain;


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
     * @var string
     */
    private string $name;

    /**
     * MovementCategory constructor.
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

    static public function createFromArray(array $data): MovementCategory
    {
        return new self(
            intval($data['ID']),
            $data['TRANSCATNAME']
        );
    }
}
