<?php

namespace Distribution\Supplier\Application\SelectList;

class SelectListSupplierResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListSupplierResponse constructor.
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
