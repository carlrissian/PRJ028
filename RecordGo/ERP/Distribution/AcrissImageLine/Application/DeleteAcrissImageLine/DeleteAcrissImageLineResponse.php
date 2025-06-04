<?php
declare(strict_types=1);

namespace Distribution\AcrissImageLine\Application\DeleteAcrissImageLine;

class DeleteAcrissImageLineResponse
{

    private $status;
    private $message;

    /**
     * @param $status
     * @param $message
     */
    public function __construct($status, $message)
    {
        $this->status = $status;
        $this->message = $message;
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


}