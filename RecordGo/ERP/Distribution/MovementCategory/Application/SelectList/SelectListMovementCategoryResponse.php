<?php

namespace Distribution\MovementCategory\Application\SelectList;

class SelectListMovementCategoryResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListMovementCategoryResponse constructor.
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
