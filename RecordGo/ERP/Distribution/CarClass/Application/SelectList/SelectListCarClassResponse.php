<?php

namespace Distribution\CarClass\Application\SelectList;

class SelectListCarClassResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListCarClassResponse constructor.
     *
     * @param array $selectList
     */
    public function __construct(array $selectList)
    {
        $this->selectList = $selectList;
    }

    /**
     * @return array
     */
    public function getSelectList(): array
    {
        return $this->selectList;
    }
}
