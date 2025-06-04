<?php

declare(strict_types=1);

namespace Distribution\Route\Application\DownloadExcelTemplate;

use Distribution\Route\Domain\RouteExcelConstants;

class DownloadExcelTemplateRouteQueryHandler
{
    /**
     * @return DownloadExcelTemplateRouteResponse
     */
    public function handle(): DownloadExcelTemplateRouteResponse
    {
        $headers = RouteExcelConstants::toArray();
        $fileName = 'routes_template.csv';

        return new DownloadExcelTemplateRouteResponse($headers, $fileName);
    }
}
