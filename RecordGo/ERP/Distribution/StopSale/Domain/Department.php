<?php

namespace Distribution\StopSale\Domain;

final class Department
{
    // FIXME sustituir por constantes BBDD
    const PRICING = 1;
    const DISTRIBUTION = 2;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * Department constructor.
     *
     * @param integer $id
     * @param string|null $name
     */
    private function __construct(int $id, ?string $name)
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
     * @param integer $id
     * @param string|null $name
     */
    public static function create(int $id, ?string $name = null): self
    {
        return new self($id, $name);
    }

    /**
     * @param array|null $departmentArray
     * @return self
     */
    public static function createFromArray(?array $departmentArray): self
    {
        return self::create(
            intval($departmentArray['ID']),
            $departmentArray['NAME'] ?? null
        );
    }
}
