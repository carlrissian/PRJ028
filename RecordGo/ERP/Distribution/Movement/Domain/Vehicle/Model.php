<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\Vehicle;


class Model
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
     * Model constructor.
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
}
