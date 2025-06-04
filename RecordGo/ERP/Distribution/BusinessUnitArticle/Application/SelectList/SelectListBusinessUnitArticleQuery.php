<?php

namespace Distribution\BusinessUnitArticle\Application\SelectList;

class SelectListBusinessUnitArticleQuery
{
    /**
     * @var int|null
     */
    private $movementTypeId;

    /**
     * SelectListBusinessUnitArticleQuery constructor.
     *
     * @param integer|null $movementTypeId
     */
    public function __construct(?int $movementTypeId)
    {
        $this->movementTypeId = $movementTypeId;
    }

    /**
     * @return int|null
     */
    public function getMovementTypeId(): ?int
    {
        return $this->movementTypeId;
    }
}
