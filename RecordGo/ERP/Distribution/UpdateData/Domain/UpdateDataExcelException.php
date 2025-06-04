<?php

declare(strict_types=1);

namespace Distribution\UpdateData\Domain;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UpdateDataExcelException  extends Exception
{
    /**
     * @var array
     */
    private $data;

    /**
     * UpdateDataExcelException constructor.
     *
     * @param string $message
     * @param array $data
     * @param integer $code
     */
    public function __construct(string $message, array $data, int $code = Response::HTTP_BAD_REQUEST)
    {
        $this->data = $data;
        parent::__construct($message, $code);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
