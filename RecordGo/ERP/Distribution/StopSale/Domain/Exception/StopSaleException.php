<?php

namespace Distribution\StopSale\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

final class StopSaleException extends \Exception
{
    /**
     * StopSaleException constructor.
     *
     * @param string $message
     * @param integer $code
     */
    public function __construct(string $message, int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code);
    }
}
