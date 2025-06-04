<?php

namespace Distribution\Damage\Application\FilterDamage;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Distribution\Damage\Domain\Damage;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Damage\Domain\DamageCriteria;
use Distribution\Damage\Domain\DamageRepository;

class FilterDamageQueryHandler
{
    /**
     * @var DamageRepository
     */
    private $damageRepository;

    /**
     * FilterDamageQueryHandler constructor.
     * 
     * @param DamageRepository $damageRepository
     */
    public function __construct(DamageRepository $damageRepository)
    {
        $this->damageRepository = $damageRepository;
    }

    /**
     * @param FilterDamageQuery $query
     * @return FilterDamageResponse
     */
    public function handle(FilterDamageQuery $query): FilterDamageResponse
    {
        /**
         * @author angel.carvajal
         * TODO desde Mostrador (28/04/2023): como necesitamos hacer un OR y no está implementado, se ha pensado en hacer 2 getBy para salir del paso.
         * Tenemos que ver como solucionar esto
         */
        $criteria = $this->setCriteria($query);
        $criteria2 = $this->setCriteria2($query);

        $damages = $this->damageRepository->getBy(($criteria))->getCollection()->toArray();
        $damages2 = [];
        if (!empty($query->getVehiclePickupDate())) {
            $damages2 = $this->damageRepository->getBy($criteria2)->getCollection()->toArray();
        }

        $totalDamages = empty($query->getVehiclePickupDate()) ? $damages : array_merge($damages, $damages2);

        // $damageList = [];
        // foreach ($totalDamages as $damage) {
        //     /**
        //      * @var Damage $damage
        //      */
        //     $damageList[] = [
        //         'id' => $damage->getId(),
        //         'typeZone' => [
        //             'id' => $damage->getTypeZone()->getId(),
        //             'name' => $damage->getTypeZone()->getName(),
        //         ],
        //         'zone' => $damage->getZone(),
        //         'subZone' => $damage->getSubZone(),
        //         'name' => $damage->getDamageName(),
        //         'raHeadId' => $damage->getRaHeadId(), // Campos añadidos para recuperar daños en ficha vehículo.
        //         'repaired' => $damage->isRepaired(),
        //         'reparationDate' => !is_null($damage->getReparationDate()) ? $damage->getReparationDate()->__toString() : null,
        //         'repairOrderId' => $damage->getRepairOrderId(),
        //     ];
        // }

        return new FilterDamageResponse($totalDamages);
    }


    /**
     * @param FilterDamageQuery $query
     * @return DamageCriteria
     */
    private function setCriteria(FilterDamageQuery $query): DamageCriteria
    {
        // $sortCollection = null;
        $filterCollection = new FilterCollection([]);

        if (!empty($query->getVehicleId())) $filterCollection->add(new Filter('VEHICLEID', new FilterOperator(FilterOperator::EQUAL), $query->getVehicleId()));

        if (!empty($query->getVehiclePickupDate())) {
            $filterCollection->add(new Filter('CREATIONDATE', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getVehiclePickupDate(), 'd/m/Y H:i:s')));
            $filterCollection->add(new Filter('REPAIREDDATE', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getVehiclePickupDate(), 'd/m/Y H:i:s')));
        }


        // if (!empty($query->getSort()) && !empty($query->getOrder())) {
        //     $sortCollection = new SortCollection([
        //         new Sort($query->getSort(), $query->getOrder())
        //     ]);
        // }
        // $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);
        $criteria = new DamageCriteria($filterCollection);

        return $criteria;
    }

    /**
     * @param FilterDamageQuery $query
     * @return DamageCriteria
     */
    private function setCriteria2(FilterDamageQuery $query): DamageCriteria
    {
        // $sortCollection = null;
        $filterCollection = new FilterCollection([]);

        if (!empty($query->getVehicleId())) $filterCollection->add(new Filter('VEHICLEID', new FilterOperator(FilterOperator::EQUAL), $query->getVehicleId()));

        if (!empty($query->getVehiclePickupDate())) {
            $filterCollection->add(new Filter('CREATIONDATE', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getVehiclePickupDate(), 'd/m/Y H:i:s')));
            $filterCollection->add(new Filter('REPAIREDDATE', new FilterOperator(FilterOperator::EQUAL), null));
        }


        // if (!empty($query->getSort()) && !empty($query->getOrder())) {
        //     $sortCollection = new SortCollection([
        //         new Sort($query->getSort(), $query->getOrder())
        //     ]);
        // }
        // $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);
        $criteria = new DamageCriteria($filterCollection);

        return $criteria;
    }
}
