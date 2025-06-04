<?php
declare(strict_types=1);

namespace Distribution\AcrissImageLine\Application\StoreAcrissImageLine;

class StoreAcrissImageLineResponse
{


    private $status;

    private $message;

    private $id;

    /**
     * @param $status
     * @param $message
     * @param $id
     */
    public function __construct($status, $message, $id)
    {
        $this->status = $status;
        $this->message = $message;
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }



}