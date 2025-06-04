<?php
declare(strict_types=1);


namespace Distribution\CarBodyType\Domain;


class CarBodyType
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
     * Bodywork constructor.
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
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

   static public function createFromArray(array $data): CarBodyType
    {
        return new self(
            $data['ID'],
            $data['VEHICLEBODYTYPENAME']
        );
    }
}