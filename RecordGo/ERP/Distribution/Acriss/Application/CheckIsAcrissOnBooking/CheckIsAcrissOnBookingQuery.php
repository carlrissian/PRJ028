<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\CheckIsAcrissOnBooking;


class CheckIsAcrissOnBookingQuery
{
    /**
     * @var int
     */
    private int $acrissId;

    /**
     * @param int $acrissId
     */
    public function __construct(int $acrissId)
    {
        $this->acrissId = $acrissId;
    }

    /**
     * @return int
     */
    public function getAcrissId(): int
    {
        return $this->acrissId;
    }


}
