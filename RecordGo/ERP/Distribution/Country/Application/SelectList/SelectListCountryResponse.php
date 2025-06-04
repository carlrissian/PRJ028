<?php

namespace Distribution\Country\Application\SelectList;

class SelectListCountryResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListCountryResponse constructor.
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
