<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\CheckIsAcrissOnBooking;


class CheckIsAcrissOnBookingResponse
{
    /**
     * @var bool
     */
    private $isAcrissOnBooking;

    /**
     * @param $isAcrissOnBooking
     */
    public function __construct($isAcrissOnBooking)
    {
        $this->isAcrissOnBooking = $isAcrissOnBooking;
    }

    /**
     * @return mixed
     */
    public function getIsAcrissOnBooking()
    {
        return $this->isAcrissOnBooking;
    }


}