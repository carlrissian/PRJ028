<?php

declare(strict_types=1);

namespace Distribution\TransportDriver\Application\StoreTransportDriver;

use Shared\Domain\ValueObject\DateValueObject;
use Distribution\TransportDriver\Domain\Country;
use Distribution\TransportDriver\Domain\TransportDriver;
use Distribution\TransportDriver\Domain\TransportDriverRepository;

class StoreTransportDriverCommandHandler
{
    /**
     * @var TransportDriverRepository
     */
    private TransportDriverRepository $transportDriverRepository;

    /**
     * @param TransportDriverRepository $transportDriverRepository
     */
    public function __construct(TransportDriverRepository $transportDriverRepository)
    {
        $this->transportDriverRepository = $transportDriverRepository;
    }

    /**
     * @param StoreTransportDriverCommand $command
     * @return StoreTransportDriverResponse
     */
    public function handle(StoreTransportDriverCommand $command): StoreTransportDriverResponse
    {
        $driver = new TransportDriver(
            null,
            $command->isInternalDriver(),
            $command->getProviderId(),
            $command->getName(),
            $command->getLastName(),
            $command->getIdNumber(),
            $command->getDriverLicense(),
            DateValueObject::createFromString($command->getIssueDate()),
            DateValueObject::createFromString($command->getExpirationDate()),
            $command->getAddress(),
            $command->getPostalCode(),
            $command->getCity(),
            // new State($command->getStateId(), $command->getStateName()),
            $command->getStateName(),
            new Country($command->getCountryId(), $command->getCountryName()),
            $command->getBranchId()
        );

        $driverId = $this->transportDriverRepository->store($driver);

        // TODO refactorizar cuando se cambie el response en WS
        $driverData = [
            'id' => $driverId,
            'internalDriver' => $driver->isInternalDriver(),
            // 'provider' => $driver->getTransportProvider(),
            'provider' => [
                'id' => $driver->getTransportProviderId(),
            ],
            'name' => $driver->getName(),
            'lastName' => $driver->getLastName(),
            'idNumber' => $driver->getIdNumber(),
            'driverLicense' => $driver->getDriverLicense(),
            'issueDate' => $driver->getIssueDate(),
            'expirationDate' => $driver->getExpirationDate(),
            'city' => $driver->getCity(),
            // 'state' => $driver->getState(),
            'state' => [
                'id' => $command->getStateId(),
                'name' => $driver->getState(),
            ],
            'country' => $driver->getCountry(),
            'postalCode' => $driver->getPostalCode(),
            'address' => $driver->getAddress(),
            // 'branch' => $driver->getBranch(),
            'branch' => [
                'id' => $driver->getBranchId(),
                'name' => $command->getBranchName(),
            ],
        ];

        return new StoreTransportDriverResponse($driverData);
    }
}
