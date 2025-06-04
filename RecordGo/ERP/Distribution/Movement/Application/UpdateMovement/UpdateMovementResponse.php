<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\UpdateMovement;

class UpdateMovementResponse
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var bool
     */
    private $success;

    /**
     * @var int|null
     */
    private $code;

    /**
     * @var string|null
     */
    private $message;

    /**
     * UpdateMovementResponse constructor.
     *
     * @param integer|null $id
     * @param boolean $success
     * @param integer|null $code
     * @param string|null $message
     */
    public function __construct(
        ?int $id,
        bool $success,
        ?int $code = null,
        ?string $message = null
    ) {
        $this->id = $id;
        $this->success = $success;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function wasSuccess(): bool
    {
        return $this->success;
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
