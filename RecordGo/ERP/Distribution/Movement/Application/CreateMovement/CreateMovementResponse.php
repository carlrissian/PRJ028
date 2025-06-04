<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\CreateMovement;

class CreateMovementResponse
{
    /**
     * @var array
     */
    private $selectList;

    public function __construct(array $selectList)
    {
        $this->selectList = $selectList;
    }

    /**
     * Get the value of selectList
     *
     * @return  array
     */
    public function getSelectList(): array
    {
        return $this->selectList;
    }
}
