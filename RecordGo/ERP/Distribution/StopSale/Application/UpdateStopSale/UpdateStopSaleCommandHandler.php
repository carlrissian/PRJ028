<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\UpdateStopSale;

use Distribution\StopSale\Domain\Day;
use Distribution\StopSale\Domain\Area;
use Distribution\StopSale\Domain\Acriss;
use Distribution\StopSale\Domain\Branch;
use Distribution\StopSale\Domain\Region;
use Distribution\StopSale\Domain\Partner;
use Distribution\StopSale\Domain\Product;
use Distribution\StopSale\Domain\SellCode;
use Distribution\StopSale\Domain\StopSale;
use Distribution\StopSale\Domain\Department;
use Distribution\StopSale\Domain\StopSaleType;
use Shared\Domain\ValueObject\DateValueObject;
use Shared\Domain\ValueObject\TimeValueObject;
use Distribution\StopSale\Domain\DayCollection;
use Distribution\StopSale\Domain\AreaCollection;
use Distribution\StopSale\Domain\AcrissCollection;
use Distribution\StopSale\Domain\BranchCollection;
use Distribution\StopSale\Domain\RegionCollection;
use Distribution\StopSale\Domain\StopSaleCategory;
use Distribution\StopSale\Domain\PartnerCollection;
use Distribution\StopSale\Domain\ProductCollection;
use Distribution\StopSale\Domain\SellCodeCollection;
use Distribution\StopSale\Domain\StopSaleRepository;
use Shared\Constants\Infrastructure\ConstantsJsonFile;

class UpdateStopSaleCommandHandler
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
     * @param UpdateStopSaleCommand $command
     * @return UpdateStopSaleResponse
     */
    final public function handle(UpdateStopSaleCommand $command): UpdateStopSaleResponse
    {
        /**
         * @var StopSale $stopSale
         */
        $stopSale = $this->stopSaleRepository->getById($command->getId());

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

            $stopSale->setAcriss($acrissCollection);
        } else {
            $stopSale->setAcriss(null);
        }

        if ($command->getRegionPickUpId()) {
            $regionPickUpCollection = new RegionCollection([]);
            foreach ($command->getRegionPickUpId() as $regionId) {
                $regionPickUpCollection->add(new Region($regionId));
            }

            $stopSale->setRegionPickUp($regionPickUpCollection);
        } else {
            $stopSale->setRegionPickUp(null);
        }
        if ($command->getAreaPickUpId()) {
            $areaPickUpCollection = new AreaCollection([]);
            foreach ($command->getAreaPickUpId() as $areaId) {
                $areaPickUpCollection->add(new Area($areaId));
            }

            $stopSale->setAreaPickUp($areaPickUpCollection);
        } else {
            $stopSale->setAreaPickUp(null);
        }

        if ($command->getBranchPickUpId()) {
            $branchPickUpCollection = new BranchCollection([]);
            foreach ($command->getBranchPickUpId() as $branchId) {
                $branchPickUpCollection->add(new Branch($branchId));
            }

            $stopSale->setBranchPickUp($branchPickUpCollection);
        } else {
            $stopSale->setBranchPickUp(null);
        }

        if ($command->getPartnersId()) {
            $partnerCollection = new PartnerCollection([]);
            foreach ($command->getPartnersId() as $partnerId) {
                $partnerCollection->add(new Partner($partnerId));
            }

            $stopSale->setPartners($partnerCollection);
        } else {
            $stopSale->setPartners(null);
        }

        if ($command->getSellCodesId()) {
            $sellCodeCollection = new SellCodeCollection([]);
            foreach ($command->getSellCodesId() as $sellCodeId) {
                $sellCodeCollection->add(new SellCode($sellCodeId));
            }

            $stopSale->setSellCodes($sellCodeCollection);
        } else {
            $stopSale->setSellCodes(null);
        }

        if ($command->getProductsId()) {
            $productCollection = new ProductCollection([]);
            foreach ($command->getProductsId() as $productId) {
                $productCollection->add(new Product($productId));
            }

            $stopSale->setProducts($productCollection);
        } else {
            $stopSale->setProducts(null);
        }

        /**
         * STANDARD
         */
        if ($command->getCategoryId() == ConstantsJsonFile::getValue('STOPSALECAT_STANDAR')) {
            if ($command->getRecurrencesId()) {
                $dayCollection = new DayCollection([]);
                foreach ($command->getRecurrencesId() as $dayId) {
                    $dayCollection->add(new Day($dayId));
                }
                $stopSale->setRecurrence($dayCollection);
            } else {
                $stopSale->setRecurrence(null);
            }
        }


        /**
         * ONE WAY
         */
        if ($command->getCategoryId() == ConstantsJsonFile::getValue('STOPSALECAT_ONEWAY')) {
            if ($command->getRegionDropOffId()) {
                $regionDropOffCollection = new RegionCollection([]);
                foreach ($command->getRegionDropOffId() as $regionId) {
                    $regionDropOffCollection->add(new Region(intval($regionId)));
                }
                $stopSale->setRegionDropOff($regionDropOffCollection);
            } else {
                $stopSale->setRegionDropOff(null);
            }

            if ($command->getAreaDropOffId()) {
                $areaDropOffCollection = new AreaCollection([]);
                foreach ($command->getAreaDropOffId() as $areaId) {
                    $areaDropOffCollection->add(new Area(intval($areaId)));
                }
                $stopSale->setAreaDropOff($areaDropOffCollection);
            } else {
                $stopSale->setAreaDropOff(null);
            }

            if ($command->getBranchDropOffId()) {
                $branchDropOffCollection = new BranchCollection([]);
                foreach ($command->getBranchDropOffId() as $branchId) {
                    $branchDropOffCollection->add(new Branch(intval($branchId)));
                }
                $stopSale->setBranchDropOff($branchDropOffCollection);
            } else {
                $stopSale->setBranchDropOff(null);
            }
        }

        $stopSale->setDepartment(new Department($command->getDepartmentId()));
        // $stopSale->setCategory(new StopSaleCategory($command->getCategoryId()));
        $stopSale->setInitDate($command->getInitDate() ? DateValueObject::createFromString($command->getInitDate()) : null);
        $stopSale->setEndDate($command->getEndDate() ? DateValueObject::createFromString($command->getEndDate()) : null);
        $stopSale->setStopSaleType(new StopSaleType($command->getStopSaleTypeId()));
        $stopSale->setStartTime($command->getStartTime() ? TimeValueObject::createFromString($command->getStartTime()) : TimeValueObject::createFromString('00:00'));
        $stopSale->setEndTime($command->getEndTime() ? TimeValueObject::createFromString($command->getEndTime()) : TimeValueObject::createFromString('23:59'));
        $stopSale->setMinDaysRent($command->getMinDaysRent());
        $stopSale->setMaxDaysRent($command->getMaxDaysRent());
        $stopSale->setConnectedVehicle($command->getConnectedVehicle());
        $stopSale->setNotes($command->getNotes());

        $response = $this->stopSaleRepository->update($stopSale);

        return new UpdateStopSaleResponse($response);
    }
}
