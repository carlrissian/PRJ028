<?php

namespace Distribution\Department\Application\SelectList;

class SelectListDepartmentResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListDepartmentResponse constructor.
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
