<?php

namespace Distribution\CommercialGroup\Application\SelectListCommercialGroup;

class SelectListCommercialGroupResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListCommercialGroupResponse constructor.
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
