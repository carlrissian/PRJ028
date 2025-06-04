<?php
declare(strict_types=1);


namespace Distribution\Movement\Application\ShowMovement;


class ShowMovementQuery
{
    /**
     * @var int
     */
    private int $id;

    /**
     * ShowMovementQuery constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}