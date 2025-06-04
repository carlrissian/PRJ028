<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\StoreStopSale;

use Distribution\StopSale\Domain\Day;
use Distribution\StopSale\Domain\Area;
use Distribution\StopSale\Domain\Acriss;
use Distribution\StopSale\Domain\Branch;
use Distribution\StopSale\Domain\Region;
use Distribution\StopSale\Domain\StopSale;
use Distribution\StopSale\Domain\Department;
use Distribution\StopSale\Domain\StopSaleType;
use Shared\Domain\ValueObject\DateValueObject;
use Shared\Domain\ValueObject\TimeValueObject;
use Distribution\StopSale\Domain\DayCollection;
use Distribution\StopSale\Domain\AreaCollection;
use Distribution\StopSale\Domain\AcrissCollection;
use Distribution\StopSale\Domain\BranchCollection;
use Distribution\StopSale\Domain\Partner;
use Distribution\StopSale\Domain\PartnerCollection;
use Distribution\StopSale\Domain\Product;
use Distribution\StopSale\Domain\ProductCollection;
use Distribution\StopSale\Domain\RegionCollection;
use Distribution\StopSale\Domain\SellCode;
use Distribution\StopSale\Domain\SellCodeCollection;
use Distribution\StopSale\Domain\StopSaleCategory;
use Distribution\StopSale\Domain\StopSaleRepository;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Svg\Tag\Stop;

class StoreStopSaleCommandHandler
{
    /**
     * @var StopSaleRepository
     */
    private StopSaleRepository $stopSaleRepository;

    /**
     * StoreStopSaleCommandHandler constructor.
     *
     * @param StopSaleRepository $stopSaleRepository
     */
    public function __construct(StopSaleRepository $stopSaleRepository)
    {
        $this->stopSaleRepository = $stopSaleRepository;
    }

    /**
     * @param StoreStopSaleCommand $command
     * @return StoreStopSaleResponse
     */
    final public function handle(StoreStopSaleCommand $command): StoreStopSaleResponse
    {
        [
            $acrissCollection,
            $regionPickUpCollection,
            $regionDropOffCollection,
            $areaPickUpCollection,
            $areaDropOffCollection,
            $branchPickUpCollection,
            $branchDropOffCollection,
            $partnerCollection,
            $sellCodeCollection,
            $productCollection,
        ] = null;

        if ($command->getAcrissId()) {
            $acrissCollection = new AcrissCollection([]);
            foreach ($command->getAcrissId() as $acrissId) {
                $acrissCollection->add(new Acriss($acrissId));
            }
        }

        if ($command->getRegionPickUpId()) {
            $regionPickUpCollection = new RegionCollection([]);
            foreach ($command->getRegionPickUpId() as $regionId) {
                $regionPickUpCollection->add(new Region($regionId));
            }
        }
        if ($command->getAreaPickUpId()) {
            $areaPickUpCollection = new AreaCollection([]);
            foreach ($command->getAreaPickUpId() as $areaId) {
                $areaPickUpCollection->add(new Area($areaId));
            }
        }

        if ($command->getBranchPickUpId()) {
            $branchPickUpCollection = new BranchCollection([]);
            foreach ($command->getBranchPickUpId() as $branchId) {
                $branchPickUpCollection->add(new Branch($branchId));
            }
        }

        if ($command->getPartnersId()) {
            $partnerCollection = new PartnerCollection([]);
            foreach ($command->getPartnersId() as $partnerId) {
                $partnerCollection->add(new Partner($partnerId));
            }
        }

        if ($command->getSellCodesId()) {
            $sellCodeCollection = new SellCodeCollection([]);
            foreach ($command->getSellCodesId() as $sellCodeId) {
                $sellCodeCollection->add(new SellCode($sellCodeId));
            }
        }

        if ($command->getProductsId()) {
            $productCollection = new ProductCollection([]);
            foreach ($command->getProductsId() as $productId) {
                $productCollection->add(new Product($productId));
            }
        }


        $dayCollection = new DayCollection([]);
        /**
         * STANDARD
         */
        if ($command->getCategoryId() === intval(ConstantsJsonFile::getValue('STOPSALECAT_STANDAR')) && $command->getRecurrencesId()) {
            foreach ($command->getRecurrencesId() as $dayId) {
                $dayCollection->add(new Day($dayId));
            }
        }

        /**
         * ONE WAY
         */
        if ($command->getCategoryId() === intval(ConstantsJsonFile::getValue('STOPSALECAT_ONEWAY'))) {
            if ($command->getRegionDropOffId()) {
                $regionDropOffCollection = new RegionCollection([]);
                foreach ($command->getRegionDropOffId() as $regionId) {
                    $regionDropOffCollection->add(new Region(intval($regionId)));
                }
            }

            if ($command->getAreaDropOffId()) {
                $areaDropOffCollection = new AreaCollection([]);
                foreach ($command->getAreaDropOffId() as $areaId) {
                    $areaDropOffCollection->add(new Area(intval($areaId)));
                }
            }

            if ($command->getBranchDropOffId()) {
                $branchDropOffCollection = new BranchCollection([]);
                foreach ($command->getBranchDropOffId() as $branchId) {
                    $branchDropOffCollection->add(new Branch(intval($branchId)));
                }
            }
        }


        $stopSale = new StopSale(
            null,
            new Department($command->getDepartmentId()),
            new StopSaleCategory($command->getCategoryId()),
            $command->getInitDate() ? DateValueObject::createFromString($command->getInitDate()) : null,
            $command->getEndDate() ? DateValueObject::createFromString($command->getEndDate()) : null,
            $acrissCollection,
            $regionPickUpCollection,
            $regionDropOffCollection,
            $areaPickUpCollection,
            $areaDropOffCollection,
            $branchPickUpCollection,
            $branchDropOffCollection,
            $partnerCollection,
            $sellCodeCollection,
            $productCollection,
            new StopSaleType($command->getStopSaleTypeId()),
            $command->getStartTime() ? TimeValueObject::createFromString($command->getStartTime()) : TimeValueObject::createFromString('00:00'),
            $command->getEndTime() ? TimeValueObject::createFromString($command->getEndTime()) : TimeValueObject::createFromString('23:59'),
            $dayCollection,
            $command->getMinDaysRent(),
            $command->getMaxDaysRent(),
            $command->getConnectedVehicle(),
            $command->getNotes(),
            false
        );

        // Si tipo es PARTIAL_CHECKOUT_CHECKIN se crean 2 Stopsale, uno tipo PARTIAL_CHECKOUT y otro tipo PARTIAL_CHECKOUT_CHECKIN
        if ($command->getStopSaleTypeId() === intval(ConstantsJsonFile::getValue('STOPSALETYPE_PARCIAL_CHECKOUT_CHECKIN'))) {
            $stopSale->setStopSaleType(new StopSaleType(intval(ConstantsJsonFile::getValue('STOPSALETYPE_PARCIAL_CHECKIN'))));
            $this->stopSaleRepository->store($stopSale);

            $stopSale->setStopSaleType(new StopSaleType(intval(ConstantsJsonFile::getValue('STOPSALETYPE_PARCIAL_CHECKOUT'))));
            $response = $this->stopSaleRepository->store($stopSale);
        } else {
            $response = $this->stopSaleRepository->store($stopSale);
        }


        return new StoreStopSaleResponse($response);
    }
}
