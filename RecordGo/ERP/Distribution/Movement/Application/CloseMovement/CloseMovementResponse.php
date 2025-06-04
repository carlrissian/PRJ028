<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\CloseMovement;

class CloseMovementResponse
{
    /**
     * @var bool
     */
    private $closed;

    /**
     * @var int
     */
    private $code;

    /**
     * @var string|null
     */
    private $message;

    /**
     * CloseMovementResponse constructor.
     *
     * @param boolean $closed
     * @param integer $code
     * @param string|null $message
     */
    public function __construct(bool $closed, int $code, string $message = null)
    {
        $this->closed = $closed;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return boolean
     */
    public function isClosed(): bool
    {
        return $this->closed;
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
