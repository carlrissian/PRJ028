<?php

declare(strict_types=1);

namespace Distribution\UpdateData\Application\DownloadExcelTemplate;

use Distribution\Location\Domain\LocationCriteria;
use Distribution\UpdateData\Domain\FileRepository;
use Distribution\Location\Domain\LocationException;
use Distribution\Location\Domain\LocationRepository;
use Distribution\UpdateData\Domain\VehicleExcelConstants;
use Distribution\VehicleStatus\Domain\VehicleStatusCriteria;
use Distribution\VehicleStatus\Domain\VehicleStatusRepository;
use Distribution\VehicleStatus\Domain\VehicleStatusNotFoundException;

class DownloadExcelTemplateUpdateDataQueryHandler
{
    /**
     * @var FileRepository
     */
    private $fileRepository;

    /**
     * @var VehicleStatusRepository
     */
    private $vehicleStatusRepository;

    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * @param FileRepository $fileRepository
     * @param VehicleStatusRepository $vehicleStatusRepository
     * @param LocationRepository $locationRepository
     */
    public function __construct(FileRepository $fileRepository, VehicleStatusRepository $vehicleStatusRepository, LocationRepository $locationRepository)
    {
        $this->fileRepository = $fileRepository;
        $this->vehicleStatusRepository = $vehicleStatusRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * @return DownloadExcelTemplateUpdateDataResponse
     */
    public function handle(): DownloadExcelTemplateUpdateDataResponse
    {
        $vehicleStatusCollection = $this->vehicleStatusRepository->getBy(new VehicleStatusCriteria())->getCollection();

        if (empty($vehicleStatusCollection)) {
            throw new VehicleStatusNotFoundException('Error while getting vehicle status list');
        }

        $locationCollection = $this->locationRepository->getBy(new LocationCriteria())->getCollection();

        if (empty($locationCollection)) {
            throw new LocationException('Error while getting location list');
        }

        $vehicleStatusList = array_map(function ($vehicleStatus) {
            return $vehicleStatus->getName();
        }, $vehicleStatusCollection->toArray());

        $locationList = array_map(function ($location) {
            return $location->getName();
        }, $locationCollection->toArray());

        $dropdownLists = [
            VehicleExcelConstants::TITLE_STATUS => [
                'values' => $vehicleStatusList,
                'allowBlank' => true,
            ],
            VehicleExcelConstants::TITLE_LOCATION => [
                'values' => $locationList,
                'allowBlank' => true,
            ],
        ];

        [$tempFile, $fileName] = $this->fileRepository->template($dropdownLists);

        return new DownloadExcelTemplateUpdateDataResponse($tempFile, $fileName);
    }
}
