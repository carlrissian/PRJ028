<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\CancelMovement;

class CancelMovementResponse
{
    /**
     * @var bool
     */
    private $cancelled;

    /**
     * @var int
     */
    private $code;

    /**
     * @var string|null
     */
    private $message;

    /**
     * CancelMovementResponse constructor.
     *
     * @param boolean $cancelled
     * @param integer $code
     * @param string|null $message
     */
    public function __construct(bool $cancelled, int $code, string $message = null)
    {
        $this->cancelled = $cancelled;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return boolean
     */
    public function isCancelled(): bool
    {
        return $this->cancelled;
    }

    /**
     * @return int
     */
    public function getCode(): int
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
