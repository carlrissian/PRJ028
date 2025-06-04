<?php

declare(strict_types=1);

namespace Distribution\Route\Application\DownloadExcelTemplate;

class DownloadExcelTemplateRouteResponse
{
    /**
     * @var array
     */
    private array $headers;

    /**
     * @var string
     */
    private string $fileName;

    /**
     * @param array $headers
     * @param string $fileName
     */
    public function __construct(array $headers, string $fileName)
    {
        $this->headers = $headers;
        $this->fileName = $fileName;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
}
