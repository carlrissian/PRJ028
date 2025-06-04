<?php

namespace Distribution\UpdateData\Application\ProcessFileUpdateData;

class ProcessFileUpdateDataResponse
{
    /**
     * @var boolean
     */
    private bool $success;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $vehicles;

    /**
     * @param bool $success
     * @param string $message
     * @param array $vehicles
     */
    public function __construct(
        bool $success,
        string $message,
        array $vehicles
    ) {
        $this->success = $success;
        $this->message = $message;
        $this->vehicles = $vehicles;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getVehicles(): array
    {
        return $this->vehicles;
    }
}
