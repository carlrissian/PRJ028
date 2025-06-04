<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

use Shared\Utils\DataValidation;

class State
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
     * State constructor.
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
     * @param array|null $stateArray
     * @return State
     */
    public static function createFromArray(?array $stateArray): State
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($stateArray, 'ID')),
            $helper->arrayExistOrNull($stateArray, 'STATENAME')
        );
    }

    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'STATENAME' => $this->getName(),
        ];
    }
}
