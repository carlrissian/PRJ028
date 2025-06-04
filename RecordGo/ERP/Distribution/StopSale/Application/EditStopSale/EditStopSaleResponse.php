<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\EditStopSale;

use Distribution\StopSale\Domain\StopSale;

class EditStopSaleResponse
{
    /**
     * @var int
     */
    private $stopSaleCategoryId;

    /**
     * @var array
     */
    private $selectList;

    /**
     * @var StopSale
     */
    private $stopSale;

    /**
     * EditStopSaleResponse constructor.
     *
     * @param integer $stopSaleCategoryId
     * @param array $selectList
     * @param StopSale $stopSale
     */
    public function __construct(
        int $stopSaleCategoryId,
        array $selectList,
        StopSale $stopSale
    ) {
        $this->stopSaleCategoryId = $stopSaleCategoryId;
        $this->selectList = $selectList;
        $this->stopSale = $stopSale;
    }

    /**
     * Get the value of stopSaleCategoryId
     *
     * @return int
     */
    public function getStopSaleCategoryId(): int
    {
        return $this->stopSaleCategoryId;
    }

    /**
     * Get the value of selectList
     *
     * @return array
     */
    public function getSelectList(): array
    {
        return $this->selectList;
    }

    /**
     * Get the value of stopSale
     *
     * @return StopSale
     */
    public function getStopSale(): StopSale
    {
        return $this->stopSale;
    }
}
