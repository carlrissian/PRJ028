<?php
declare(strict_types=1);


namespace Distribution\CarGroup\Application\FilterCarGroup;

class FilterCarGroupResponse
{
  /**
   * @var array
   */
  private array $carGroupList;
  /**
   * @var int
   */
  private int $total;

    /**
     * @param array $carGroupList
     * @param int $total
     */
    public function __construct(array $carGroupList, int $total)
    {
        $this->carGroupList = $carGroupList;
        $this->total = $total;
    }

    /**
     * @return array
     */
    public function getCarGroupList(): array
    {
        return $this->carGroupList;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }



}