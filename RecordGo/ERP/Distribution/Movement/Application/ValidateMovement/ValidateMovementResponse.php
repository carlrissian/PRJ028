<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\ValidateMovement;

class ValidateMovementResponse
{
    /**
     * @var bool
     */
    private $validated;

    /**
     * @param string|null
     */
    private $message;

    public function __construct(bool $validated, ?string $message = null)
    {
        $this->validated = $validated;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isValidated(): bool
    {
        return $this->validated;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
}
