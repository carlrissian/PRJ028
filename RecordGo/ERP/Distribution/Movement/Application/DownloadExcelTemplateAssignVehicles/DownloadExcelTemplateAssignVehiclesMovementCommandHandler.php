<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\DownloadExcelTemplateAssignVehicles;

use Distribution\Movement\Domain\AssignVehicle\AssignVehicleConstants;

class DownloadExcelTemplateAssignVehiclesMovementCommandHandler
{
    /**
     * @return DownloadExcelTemplateUpdateDataResponse
     */
    public function handle(): DownloadExcelTemplateAssignVehiclesMovementResponse
    {
        $headers = AssignVehicleConstants::toArray();
        $fileName = 'assign_vehicle_template.csv';

        return new DownloadExcelTemplateAssignVehiclesMovementResponse($headers, $fileName);
    }
}
