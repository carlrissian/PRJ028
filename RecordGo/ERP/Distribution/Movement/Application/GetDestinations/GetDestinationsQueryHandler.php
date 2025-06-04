<?php
declare(strict_types=1);

namespace Distribution\Movement\Application\GetDestinations;



use Distribution\Location\Domain\LocationCriteria;
use Distribution\Location\Domain\LocationException;
use Distribution\Location\Domain\LocationRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

class GetDestinationsQueryHandler
{
    /**
     * @var LocationRepository
     */
    private LocationRepository $destinationsRepository;

    /**
     * FilterPlanningQueryHandler constructor.
     * @param LocationRepository $destinationsRepository
     */
    public function __construct(LocationRepository $destinationsRepository)
    {
        $this->destinationsRepository = $destinationsRepository;
    }

    /**
     * @throws LocationException
     */
    public function handle(GetDestinationsQuery $query)
    {
        $originId = $query->getOriginId();
        $branchGroupId = $query->getBranchGroupId();
        $locationTypeId = $query->getLocationTypeId();

        $locationsFilterCollection = new FilterCollection([]);

        if(!empty($locationTypeId)) {
            $locationsFilterCollection->add(new Filter('LOCATIONTYPEID', new FilterOperator(FilterOperator::IN), $locationTypeId));
        }

        //TODO REVISAR ESTE FILTRO
//        if(!empty($originId)) {
//            $locationsFilterCollection->add(new Filter('BRANCHID', new FilterOperator(FilterOperator::NOT_EQUAL), $originId));
//        }

        if(!empty($branchGroupId)){
            $locationsFilterCollection->add(new Filter('BRANCHGROUPID', new FilterOperator(FilterOperator::EQUAL), $branchGroupId));
        }

        [$locationsCollection, $totalRows] = $this->destinationsRepository->getBy(
            new LocationCriteria(
                $locationsFilterCollection
            ))->toArray();


        if($locationsCollection){
            $locationsList=[];
            foreach($locationsCollection as $object) {
                $locationsList[]= [
                    'id' => $object->getId(),
                    'name' => $object->getName(),
                    'branchIATA' => $object->getBranch()->getBranchIATA(),
                    'branchGroupId' => $object->getBranch()->getBranchGroupId()
                ];
            }
        }else{
            throw new LocationException('locations not founded.');
        }

        return new GetDestinationsResponse($locationsList);
    }
}
