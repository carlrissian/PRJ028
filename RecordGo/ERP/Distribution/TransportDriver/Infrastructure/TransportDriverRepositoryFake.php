<?php

namespace Distribution\TransportDriver\Infrastructure;

use DateTime;
use Faker\Factory;
use Distribution\TransportDriver\Domain\Country;
use Distribution\TransportDriver\Domain\TransportDriver;
use Distribution\TransportDriver\Domain\TransportDriverCollection;
use Distribution\TransportDriver\Domain\TransportDriverCriteria;
use Distribution\TransportDriver\Domain\TransportDriverGetByResponse;
use Distribution\TransportDriver\Domain\TransportDriverRepository;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\ValueObject\DateValueObject;

class TransportDriverRepositoryFake implements TransportDriverRepository
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function getBy(TransportDriverCriteria $criteria): TransportDriverGetByResponse
    {
        $count = ($criteria->getPagination()) ? 100 : 50;

        $name = null;
        $lastName = null;
        $idNumber = null;
        $driverLicense = null;
        $issueDate = null;
        $expirationDate = null;
        $city = null;
        $countryId = null;

        if ($criteria->hasFilters()) {
            $name = ($criteria->getFilters(['name'])[0]) ? $criteria->getFilters(['name'])[0]->getValue() : null;
            $lastName = ($criteria->getFilters(['lastName'])[0]) ? $criteria->getFilters(['lastName'])[0]->getValue() : null;
            $idNumber = ($criteria->getFilters(['idNumber'])[0]) ? $criteria->getFilters(['idNumber'])[0]->getValue() : null;
            $driverLicense = ($criteria->getFilters(['driverLicense'])[0]) ? $criteria->getFilters(['driverLicense'])[0]->getValue() : null;
            $issueDate = ($criteria->getFilters(['issueDate'])[0]) ? $criteria->getFilters(['issueDate'])[0]->getValue() : null;
            $expirationDate = ($criteria->getFilters(['expirationDate'])[0]) ? $criteria->getFilters(['expirationDate'])[0]->getValue() : null;
            $city = ($criteria->getFilters(['city'])[0]) ? $criteria->getFilters(['city'])[0]->getValue() : null;
            $countryId = ($criteria->getFilters(['countryId'])[0]) ? $criteria->getFilters(['countryId'])[0]->getValue() : null;

            if ($driverLicense || $idNumber) $count = 1;
        }
        $objectArray = [];
        for ($i = 0; $i < $count; $i++) {
            $td = $this->create(
                $i,
                $name,
                $lastName,
                $idNumber,
                $driverLicense,
                $issueDate,
                $expirationDate,
                $city,
                $countryId
            );
            $objectArray[] = $td;
        }

        // Filtros
        if ($criteria->hasFilters()) {
            foreach ($criteria->getFilters(['name'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var TransportDriver $object
                         */
                        return $object->getName() === $filter->getValue();
                    }
                );
            }

            foreach ($criteria->getFilters(['lastName'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var TransportDriver $object
                         */
                        return $object->getLastName() === $filter->getValue();
                    }
                );
            }

            foreach ($criteria->getFilters(['idNumber'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var TransportDriver $object
                         */
                        return $object->getIdNumber() === $filter->getValue();
                    }
                );
            }

            foreach ($criteria->getFilters(['driverLicense'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var TransportDriver $object
                         */
                        return $object->getDriverLicense() === $filter->getValue();
                    }
                );
            }

            foreach ($criteria->getFilters(['issueDate'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var TransportDriver $object
                         */
                        return $object->getIssueDate() === $filter->getValue();
                    }
                );
            }

            foreach ($criteria->getFilters(['expirationDate'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var TransportDriver $object
                         */
                        return $object->getExpirationDate() === $filter->getValue();
                    }
                );
            }

            foreach ($criteria->getFilters(['city'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var TransportDriver $object
                         */
                        return $object->getCity() === $filter->getValue();
                    }
                );
            }

            foreach ($criteria->getFilters(['countryId'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var TransportDriver $object
                         */
                        return $object->getCountry()->getId() === $filter->getValue();
                    }
                );
            }
        }

        $totalRows = count($objectArray);

        // Paginación
        if ($criteria->hasPagination()) {
            $offset = $criteria->getPagination()->getOffset();
            $limit = $criteria->getPagination()->getLimit();
        } else {
            $offset = 0;
            $limit = $totalRows;
        }

        $objectArray = array_values($objectArray);

        $paginationArray = [];

        for ($i = 0; $i < $totalRows; $i++) {
            if ($i >= $offset && $i < $offset + $limit) {
                $paginationArray[] = $objectArray[$i];
            }
        }

        $collection = new TransportDriverCollection($paginationArray);

        return new TransportDriverGetByResponse($collection, $totalRows);
    }

    public function getById(int $id): TransportDriver
    {
        return $this->create($id);
    }

    public function store(TransportDriver $transportDriver): int
    {
        $transportDriver->setId($this->faker->numberBetween(0, 1000));
        return $transportDriver->getId();
    }

    public function create(
        $id = null,
        $name = null,
        $lastName = null,
        $idNumber = null,
        $driverLicense = null,
        $issueDate = null,
        $expirationDate = null,
        $city = null,
        $countryId = null
    ): TransportDriver {
        $internalDriver = $this->faker->boolean();
        $active = $this->faker->boolean();

        return new TransportDriver(
            (is_null($id)) ? $this->faker->numberBetween(0, 1000) : $id,
            $internalDriver,
            (!$internalDriver) ? $this->faker->numberBetween(0, 1000) : null,
//            ($internalDriver) ? $this->faker->numberBetween(0, 1000) : null,
            (is_null($name)) ? $this->faker->name : $name,
            (is_null($lastName)) ? $this->faker->lastName : $lastName,
            (is_null($idNumber)) ? $this->faker->regexify('^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$') : $idNumber,
            (is_null($driverLicense)) ? $this->faker->creditCardNumber() : $driverLicense,
            (is_null($issueDate)) ? new DateValueObject(new DateTime()) : $issueDate,
            (is_null($expirationDate)) ? new DateValueObject(new DateTime()) : $expirationDate,
            $this->faker->address,
//            ($this->faker->boolean()) ? $this->faker->address : null,
            $this->faker->regexify('^[0-9]{5}'),
            (is_null($city)) ? $this->faker->city : $city,
            $this->faker->state,
            (is_null($countryId)) ? new Country($this->faker->numberBetween(0, 15), $this->faker->country) : new Country($countryId, $this->faker->country),
            $this->faker->numberBetween(0, 1000),
//            $active,
//            (!$active) ? $this->faker->sentence() : null
        );
    }
}
