<?php

namespace Distribution\StopSale\Application\StoreStopSale;

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

final class StoreStopSaleCommandHandler
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
            $pickUpRegionCollection,
            $pickUpAreaCollection,
            $pickUpBranchCollection,
            $dropOffRegionCollection,
            $dropOffAreaCollection,
            $dropOffBranchCollection,
            $partnerCollection,
            $sellCodeCollection,
            $productCollection,
        ] = null;

        if ($command->getAcrissId()) {
            $acrissCollection = new AcrissCollection([]);
            foreach ($command->getAcrissId() as $acrissId) {
                $acrissCollection->add(Acriss::create($acrissId));
            }
        }

        if ($command->getPickUpRegionId()) {
            $pickUpRegionCollection = new RegionCollection([]);
            foreach ($command->getPickUpRegionId() as $regionId) {
                $pickUpRegionCollection->add(Region::create($regionId));
            }
        }
        if ($command->getPickUpAreaId()) {
            $pickUpAreaCollection = new AreaCollection([]);
            foreach ($command->getPickUpAreaId() as $areaId) {
                $pickUpAreaCollection->add(Area::create($areaId));
            }
        }

        if ($command->getPickUpBranchId()) {
            $pickUpBranchCollection = new BranchCollection([]);
            foreach ($command->getPickUpBranchId() as $branchId) {
                $pickUpBranchCollection->add(Branch::create($branchId));
            }
        }

        if ($command->getPartnersId()) {
            $partnerCollection = new PartnerCollection([]);
            foreach ($command->getPartnersId() as $partnerId) {
                $partnerCollection->add(Partner::create($partnerId));
            }
        }

        if ($command->getSellCodesId()) {
            $sellCodeCollection = new SellCodeCollection([]);
            foreach ($command->getSellCodesId() as $sellCodeId) {
                $sellCodeCollection->add(SellCode::create($sellCodeId));
            }
        }

        if ($command->getProductsId()) {
            $productCollection = new ProductCollection([]);
            foreach ($command->getProductsId() as $productId) {
                $productCollection->add(Product::create($productId));
            }
        }


        $dayCollection = new DayCollection([]);
        /**
         * STANDARD
         */
        if ($command->getCategoryId() === intval(ConstantsJsonFile::getValue('STOPSALECAT_STANDAR')) && $command->getRecurrencesId()) {
            foreach ($command->getRecurrencesId() as $dayId) {
                $dayCollection->add(Day::create($dayId));
            }
        }

        /**
         * ONE WAY
         */
        if ($command->getCategoryId() === intval(ConstantsJsonFile::getValue('STOPSALECAT_ONEWAY'))) {
            if ($command->getDropOffRegionId()) {
                $dropOffRegionCollection = new RegionCollection([]);
                foreach ($command->getDropOffRegionId() as $regionId) {
                    $dropOffRegionCollection->add(Region::create($regionId));
                }
            }

            if ($command->getDropOffAreaId()) {
                $dropOffAreaCollection = new AreaCollection([]);
                foreach ($command->getDropOffAreaId() as $areaId) {
                    $dropOffAreaCollection->add(Area::create($areaId));
                }
            }

            if ($command->getDropOffBranchId()) {
                $dropOffBranchCollection = new BranchCollection([]);
                foreach ($command->getDropOffBranchId() as $branchId) {
                    $dropOffBranchCollection->add(Branch::create($branchId));
                }
            }
        }


        $stopSale = StopSale::create(
            null,
            Department::create($command->getDepartmentId()),
            StopSaleCategory::create($command->getCategoryId()),
            $command->getInitDate() ? DateValueObject::createFromString($command->getInitDate()) : null,
            $command->getEndDate() ? DateValueObject::createFromString($command->getEndDate()) : null,
            $acrissCollection,
            $pickUpRegionCollection,
            $pickUpAreaCollection,
            $pickUpBranchCollection,
            $dropOffRegionCollection,
            $dropOffAreaCollection,
            $dropOffBranchCollection,
            $partnerCollection,
            $sellCodeCollection,
            $productCollection,
            StopSaleType::create($command->getStopSaleTypeId()),
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
            $stopSalePartialCheckIn = StopSale::create(
                null,
                $stopSale->getDepartment(),
                $stopSale->getCategory(),
                $stopSale->getInitDate(),
                $stopSale->getEndDate(),
                $stopSale->getAcriss(),
                $stopSale->getPickUpRegion(),
                $stopSale->getPickUpArea(),
                $stopSale->getPickUpBranch(),
                $stopSale->getDropOffRegion(),
                $stopSale->getDropOffArea(),
                $stopSale->getDropOffBranch(),
                $stopSale->getPartners(),
                $stopSale->getSellCodes(),
                $stopSale->getProducts(),
                StopSaleType::create(intval(ConstantsJsonFile::getValue('STOPSALETYPE_PARCIAL_CHECKIN'))),
                $stopSale->getStartTime(),
                $stopSale->getEndTime(),
                $stopSale->getRecurrence(),
                $stopSale->getMinDaysRent(),
                $stopSale->getMaxDaysRent(),
                $stopSale->isConnectedVehicle(),
                $stopSale->getNotes(),
                false
            );
            $this->stopSaleRepository->store($stopSalePartialCheckIn);

            $stopSalePartialCheckOut = StopSale::create(
                null,
                $stopSale->getDepartment(),
                $stopSale->getCategory(),
                $stopSale->getInitDate(),
                $stopSale->getEndDate(),
                $stopSale->getAcriss(),
                $stopSale->getPickUpRegion(),
                $stopSale->getPickUpArea(),
                $stopSale->getPickUpBranch(),
                $stopSale->getDropOffRegion(),
                $stopSale->getDropOffArea(),
                $stopSale->getDropOffBranch(),
                $stopSale->getPartners(),
                $stopSale->getSellCodes(),
                $stopSale->getProducts(),
                StopSaleType::create(intval(ConstantsJsonFile::getValue('STOPSALETYPE_PARCIAL_CHECKOUT'))),
                $stopSale->getStartTime(),
                $stopSale->getEndTime(),
                $stopSale->getRecurrence(),
                $stopSale->getMinDaysRent(),
                $stopSale->getMaxDaysRent(),
                $stopSale->isConnectedVehicle(),
                $stopSale->getNotes(),
                false
            );
            $response = $this->stopSaleRepository->store($stopSalePartialCheckOut);
        } else {
            $response = $this->stopSaleRepository->store($stopSale);
        }


        return new StoreStopSaleResponse($response);
    }
}
