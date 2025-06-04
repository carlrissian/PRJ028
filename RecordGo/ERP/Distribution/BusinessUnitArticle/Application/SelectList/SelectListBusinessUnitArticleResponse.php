<?php

namespace Distribution\BusinessUnitArticle\Application\SelectList;

class SelectListBusinessUnitArticleResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListBusinessUnitArticleResponse constructor.
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
