<?php

namespace Distribution\Movement\Application\FilterVehicleToAssign;

class FilterVehicleToAssignResponse
{
    /**
     * @var array $rows
     */
    private $rows;

    /**
     * @var int $totalRows
     */
    private $totalRows;

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
     * FilterVehicleToAssignResponse constructor.
     *
     * @param array $rows
     * @param integer $totalRows
     * @param boolean $success
     * @param integer|null $code
     * @param string|null $message
     */
    public function __construct(
        array $rows,
        int $totalRows,
        bool $success,
        ?int $code = null,
        ?string $message = null
    ) {
        $this->rows = $rows;
        $this->totalRows = $totalRows;
        $this->success = $success;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * @return int
     */
    public function getTotalRows(): int
    {
        return $this->totalRows;
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
