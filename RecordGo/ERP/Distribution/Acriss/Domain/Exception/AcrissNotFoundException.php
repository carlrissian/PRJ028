<?php

namespace Distribution\Acriss\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class AcrissNotFoundException extends \Exception
{
    /**
     * AcrissNotFoundException constructor.
     *
     * @param string $message
     * @param integer $code
     */
    public function __construct(string $message, int $code = Response::HTTP_NOT_FOUND)
    {
        parent::__construct($message, $code);
    }
}
