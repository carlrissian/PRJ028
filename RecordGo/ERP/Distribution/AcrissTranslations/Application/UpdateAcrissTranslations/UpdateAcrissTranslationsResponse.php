<?php
declare(strict_types=1);

namespace Distribution\AcrissTranslations\Application\UpdateAcrissTranslations;

class UpdateAcrissTranslationsResponse
{

    private string $status;

    private string $message;

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
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }


}