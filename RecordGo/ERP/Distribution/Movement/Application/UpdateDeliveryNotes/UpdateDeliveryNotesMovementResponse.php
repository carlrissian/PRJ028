<?php

namespace Distribution\Movement\Application\UpdateDeliveryNotes;

class UpdateDeliveryNotesMovementResponse
{
    /**
     * @var bool
     */
    private bool $uploaded;

    /**
     * @var int|null
     */
    private $code;

    /**
     * @var string|null
     */
    private $message;

    /**
     * UpdateDeliveryNotesMovementResponse constructor.
     * 
     * @param bool $uploaded
     * @param int|null $code
     * @param string|null $message
     */
    public function __construct(
        bool $uploaded,
        ?int $code = null,
        ?string $message = null
    ) {
        $this->uploaded = $uploaded;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isUploaded(): bool
    {
        return $this->uploaded;
    }

    /**
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
}
