<?php

declare(strict_types=1);

namespace Distribution\MovementStatus\Domain;

use Shared\Utils\DataValidation;

class MovementStatus
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
     * MovementStatus constructor.
     * 
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
     * @param array $movementStatusArray
     * @return MovementStatus
     */
    public static function createFromArray(array $movementStatusArray): MovementStatus
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($movementStatusArray, 'ID')),
            $helper->arrayExistOrNull($movementStatusArray, 'TRANSPORTSTATUS')
        );
    }
}
