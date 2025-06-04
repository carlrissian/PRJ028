<?php

namespace Distribution\Route\Application\ProcessFileRoute;

class ProcessFileRouteResponse
{
    /**
     * @var bool
     */
    private $completed;

    /**
     * @var string
     */
    private $messages;

    /**
     * @var array
     */
    private $affectedRoutes;

    /**
     * ProcessFileRouteResponse constructor.
     *
     * @param boolean $completed
     * @param string $messages
     * @param array $affectedRoutes
     */
    public function __construct(bool $completed, string $messages, array $affectedRoutes)
    {
        $this->completed = $completed;
        $this->messages = $messages;
        $this->affectedRoutes = $affectedRoutes;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    /**
     * @return string
     */
    public function getMessages(): string
    {
        return $this->messages;
    }

    /**
     * @return array
     */
    public function getAffectedRoutes(): array
    {
        return $this->affectedRoutes;
    }
}
