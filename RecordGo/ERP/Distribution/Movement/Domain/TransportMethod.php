<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


class TransportMethod
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
     * TransportMethod constructor.
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