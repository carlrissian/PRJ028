<?php

namespace Distribution\Route\Application\ListRoute;

class ListRouteResponse
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
     * @return  array
     */
    public function getSelectList(): array
    {
        return $this->selectList;
    }
}
