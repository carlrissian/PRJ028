<?php

namespace Distribution\Branch\Application\SelectList;

class SelectListBranchResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListBranchResponse constructor.
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
