<?php
declare(strict_types=1);

namespace Distribution\CarGroup\Application\UpdateCarGroup;


/**
 * Class UpdateCarGroupCommand
 * @package Distribution\CarGroup\Application\UpdateCarGroup
 */
class UpdateCarGroupCommand
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


}