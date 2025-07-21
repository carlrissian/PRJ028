<?php

namespace Distribution\AcrissBranchTranslations\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class AcrissBranchTranslationException extends \Exception
{
    /**
     * AcrissBranchTranslationException constructor.
     *
     * @param string $message
     * @param integer $code
     */
    public function __construct(string $message, int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code);
    }
}
