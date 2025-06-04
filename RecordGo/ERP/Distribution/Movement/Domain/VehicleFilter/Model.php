<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\VehicleFilter;

class Model
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
     * Model constructor.
     * 
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
     * @param array|null $modelArray
     * @return Model
     */
    public static function createFromArray(?array $modelArray): Model
    {
        return new self(
            intval($modelArray['ID']),
            $modelArray['MODELNAME']
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
        ];
    }
}
