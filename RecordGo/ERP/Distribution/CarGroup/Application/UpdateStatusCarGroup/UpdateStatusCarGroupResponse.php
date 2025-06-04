<?php
declare(strict_types=1);


namespace Distribution\CarGroup\Application\UpdateStatusCarGroup;


class UpdateStatusCarGroupResponse
{
    /**
     * @var string
     */
    private string $status;
    /**
     * @var string
     */
    private string $message;

    /**
     * @param string $status
     * @param string $message
     */
    public function __construct(string $status, string $message)
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