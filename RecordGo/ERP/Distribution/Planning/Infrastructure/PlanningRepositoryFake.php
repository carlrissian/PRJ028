<?php
declare(strict_types=1);


namespace Distribution\Planning\Infrastructure;

use Distribution\Planning\Domain\Acriss;
use Distribution\Planning\Domain\AssignedVehicle;
use Distribution\Planning\Domain\AssignedVehicleCollection;
use Distribution\Branch\Domain\Branch;
use Distribution\Planning\Domain\Brand;
use Distribution\Planning\Domain\CarGroup;
use Distribution\Planning\Domain\CarClass;
use Distribution\Planning\Domain\CommercialGroup;
use Distribution\Planning\Domain\GearBox;
use Distribution\Planning\Domain\Model;
use Distribution\Planning\Domain\MotorizationType;
use Distribution\Planning\Domain\OrPlanPlanning;
use Distribution\Planning\Domain\Planning;
use Distribution\Planning\Domain\PlanningFilterCriteria;
use Distribution\Planning\Domain\PlanningLine;
use Distribution\Planning\Domain\PlanningLineCollection;
use Distribution\Planning\Domain\PlanningRepository;
use Distribution\Planning\Domain\PurchaseMethod;
use Distribution\Planning\Domain\PurchaseType;
use Distribution\Planning\Domain\Delegation;
use Distribution\Planning\Domain\DelegationCollection;
use Faker\Factory;
use Faker\Generator;


class PlanningRepositoryFake implements PlanningRepository
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * @throws InvalidAcrissException
     */
    public function getPlanningBy(PlanningFilterCriteria $criteria): Planning
    {

        $delegationCollection = new AssignedVehicleCollection([]);
        $delegationCollection->add(new AssignedVehicle(
                new Branch(1, null, 'Alicante','ATH'),
                4
            )
        );
        $delegationCollection->add(new AssignedVehicle(
                new Branch(2, null, 'Málaga','SKG'),
                6
            )
        );
        $delegationCollection->add(new AssignedVehicle(
                new Branch(3, null, 'Sevilla', 'SPA'),
                0
            )
        );
        $delegationCollection->add(new AssignedVehicle(
                new Branch(4, null, 'Palma', 'COR'),
                0
            )
        );
        $delegationCollection->add(new AssignedVehicle(
                new Branch(5, null, 'Valencia', 'ZHK'),
                2
            )
        );
        $delegationCollection->add(new AssignedVehicle(
                new Branch(6, null, 'SANTS', 'AAA'),
                0
            )
        );
        $delegationCollection->add(new AssignedVehicle(
                new Branch(7, null, 'EL PRAT', 'PEL'),
                0
            )
        );

        $modelCode = $this->faker->uuid;

        $planningLineCollection = new PlanningLineCollection([]);
        $planningLineCollection->add( new PlanningLine(
            1,
            $modelCode,
            $delegationCollection,
            null,
            new Brand(4, 'Seat'),
            new Model(2, 'Arona'),
            new PurchaseMethod(1, 'BB'),
            new PurchaseType(1, 'VN'),
            new GearBox(1, 'Manual', 'M'),
            new MotorizationType(2, 'GASOLINA', 'G'),
            null,
            null,
            null,
            null,
            $this->faker->boolean,
            50
     ));

        $modelCode = $this->faker->uuid;
        $planningLineCollection->add( new PlanningLine(
            2,
            $modelCode,
            $delegationCollection,
            null,
            new Brand(1, 'Mercedes'),
            new Model(2, 'Gla'),
            new PurchaseMethod(1, 'BB'),
            new PurchaseType(1, 'VN'),
            new GearBox(1, 'Manual', 'M'),
            new MotorizationType(2, 'GASOLINA', 'G'),
            new Acriss(1, 'MKSR'),
            new CarGroup(1, 'B'),
            new CommercialGroup(1, $this->faker->name),
            new CarClass(1, 'carClass'),
            $this->faker->boolean,
            40
        ));

        $modelCode = $this->faker->uuid;
        $planningLineCollection->add(new PlanningLine(
            3,
            $modelCode,
            $delegationCollection,
            null,
            new Brand(1, 'Mercedes'),
            new Model(3, 'GLC'),
            new PurchaseMethod(1, 'RISK'),
            new PurchaseType(2, 'VN'),
            new GearBox(1, 'Manual', 'M'),
            new MotorizationType(2, 'GASOLINA', 'G'),
            null,
            null,
            null,
            null,
            $this->faker->boolean,
            30
        ));

        $modelCode = $this->faker->uuid;
        $planningLineCollection->add( new PlanningLine(
            4,
            $modelCode,
            $delegationCollection,
            false,
            new Brand(1, 'Mercedes'),
            new Model(4, 'GLB'),
            new PurchaseMethod(1, 'BB'),
            new PurchaseType(1, 'VN'),
            new GearBox(1, 'Automatico', 'A'),
            new MotorizationType(2, 'DIESEL', 'D'),
            new Acriss(1, 'MBAV'),
            new CarGroup(1, 'B'),
            new CommercialGroup(1, $this->faker->name),
            new CarClass(1, 'Mini'),
            $this->faker->boolean,
            20
        ));

        $modelCode = $this->faker->uuid;
        $planningLineCollection->add( new PlanningLine(
            5,
            $modelCode,
            $delegationCollection,
            false,
            new Brand(1, 'Mercedes'),
            new Model(4, 'GLB'),
            new PurchaseMethod(1, 'RENTING'),
            new PurchaseType(1, 'VN'),
            new GearBox(1, 'Automatico', 'A'),
            new MotorizationType(2, 'DIESEL', 'D'),
            new Acriss(1, 'JPLM'),
            new CarGroup(1, 'B'),
            new CommercialGroup(1, $this->faker->name),
            new CarClass(3, 'Economy'),
            $this->faker->boolean,
            120
        ));

        $modelCode = $this->faker->uuid;
        $planningLineCollection->add( new PlanningLine(
            6,
            $modelCode,
            new AssignedVehicleCollection([
                new AssignedVehicle(
                    new Branch(1, null,'Alicante', 'ALC'),
                    0 ),
                new AssignedVehicle(
                    new Branch(2, null,'Málaga', 'MLG'),
                    0 ),
                new AssignedVehicle(
                    new Branch(3, null,'Sevilla', 'SEV'),
                    0 ),
                new AssignedVehicle(
                    new Branch(4, null,'Palma', 'PAL'),
                    0 ),
                new AssignedVehicle(
                    new Branch(5, null,'Valencia', 'VAL'),
                    0 ),
                new AssignedVehicle(
                    new Branch(6, null,'SANTS', 'SAT'),
                    0 ),
                new AssignedVehicle(
                    new Branch(7, null,'EL PRAT', 'PRA'),
                    0 )

            ]),
            true,
            new Brand(5, 'Hyundai'),
            new Model(9, 'Kona'),
            new PurchaseMethod(1, 'BB'),
            new PurchaseType(1, 'VN'),
            new GearBox(1, 'Automatico', 'A'),
            new MotorizationType(2, 'HIBRIDO', 'H'),
            new Acriss(1, 'MBAG'),
            new CarGroup(1, 'C'),
            new CommercialGroup(1, $this->faker->name),
            new CarClass(4, 'Compact'),
            $this->faker->boolean,
            300
        ));

        //Mostramos los totales y el or plan
        $orPlanDelegationCollection = new DelegationCollection([]);
        $orPlanDelegationCollection->add(new Delegation(
                new Branch(1, null,'Alicante','ALC'),
                0
            )
        );
        $orPlanDelegationCollection->add(new Delegation(
            new Branch(2, null,'Málaga','MLG'),
            0
        ));
        $orPlanDelegationCollection->add(new Delegation(
            new Branch(3, null,'Sevilla', 'SEV'),
            0
        ));
        $orPlanDelegationCollection->add(new Delegation(
            new Branch(4, null,'Palma', 'PAL'),
            0
        ));
        $orPlanDelegationCollection->add(new Delegation(
            new Branch(5, null,'Valencia', 'VAL'),
            0
        ));
        $orPlanDelegationCollection->add(new Delegation(
            new Branch(6, null,'SANTS', 'SAT'),
            0
        ));

        $orPlanDelegationCollection->add(new Delegation(
            new Branch(7, null,'EL PRAT', 'PRA'),
            0
        ));

        return new Planning(
            1,
            2015,
            1,
            $planningLineCollection,
            new OrPlanPlanning($orPlanDelegationCollection),
            null,
            null,
            null,
            null
        );
    }

    public function store(Planning $planning): Planning
    {
        return new Planning(
            1,
            $planning->getYear(),
            $planning->getMonth(),
            $planning->getPlanningLineCollection(),
            $planning->getOrPlanPlanning(),
            $planning->getCreationUser(),
            $planning->getCreationDate(),
            $planning->getEditionUser(),
            $planning->getEditionDate()
        );
    }
}
