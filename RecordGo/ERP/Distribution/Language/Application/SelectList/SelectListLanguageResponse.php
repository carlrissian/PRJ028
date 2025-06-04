<?php

declare(strict_types=1);

namespace Distribution\Language\Application\SelectList;

class SelectListLanguageResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListLanguageResponse constructor.
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
