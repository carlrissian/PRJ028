<?php

declare(strict_types=1);

namespace Distribution\StopSale\Domain;

class Department
{
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
     * @param array|null $departmentArray
     * @return self
     */
    final public static function createFromArray(?array $departmentArray): self
    {
        return new self(
            intval($departmentArray['ID']),
            $departmentArray['NAME'] ?? null
        );
    }
}
