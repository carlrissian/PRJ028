<?php

declare(strict_types=1);

namespace Distribution\Department\Domain;

use Shared\Utils\DataValidation;

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
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array|null $departmentArray
     * @return Department
     */
    public static function createFromArray(?array $departmentArray): Department
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($departmentArray, 'ID')),
            $helper->arrayExistOrNull($departmentArray, 'NAME')
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'NAME' => $this->getName(),
        ];
    }
}
