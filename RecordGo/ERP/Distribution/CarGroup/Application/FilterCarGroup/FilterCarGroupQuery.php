<?php
declare(strict_types=1);


namespace Distribution\CarGroup\Application\FilterCarGroup;


class FilterCarGroupQuery
{
    /**
     * @var int|null
     */
    private ?int $limit;
    /**
     * @var int|null
     */
    private ?int $offset;
   /**
    * @var array|null
    */
   private ?array $carGroupList;
   /**
    * @var string|null
    */
   private ?string $acrissName;
   /**
    * @var string|null
    */
   private ?string $status;

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $carGroupList
     * @param string|null $acrissName
     * @param string|null $status
     */
    public function __construct(?int $limit, ?int $offset, ?array $carGroupList, ?string $acrissName, ?string $status)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->carGroupList = $carGroupList;
        $this->acrissName = $acrissName;
        $this->status = $status;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return array|null
     */
    public function getCarGroupList(): ?array
    {
        return $this->carGroupList;
    }

    /**
     * @return string|null
     */
    public function getAcrissName(): ?string
    {
        return $this->acrissName;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

}