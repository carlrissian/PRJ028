<?php
declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\FilterCommercialGroup;

class FilterCommercialGroupResponse
{
    /**
     * @var array
     */
    private array $commercialGroupList;
    /**
     * @var int
     */
    private int $totalRow;

    /**
     * @param array $commercialGroupList
     * @param int $totalRow
     */
    public function __construct(array $commercialGroupList, int $totalRow)
    {
        $this->commercialGroupList = $commercialGroupList;
        $this->totalRow = $totalRow;
    }

    /**
     * @return array
     */
    public function getCommercialGroupList(): array
    {
        return $this->commercialGroupList;
    }

    /**
     * @return int
     */
    public function getTotalRow(): int
    {
        return $this->totalRow;
    }

}
