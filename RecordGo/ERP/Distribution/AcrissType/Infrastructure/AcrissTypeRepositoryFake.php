<?php
declare(strict_types=1);

namespace Distribution\AcrissType\Infrastructure;

use Distribution\Acriss\Domain\AcrissNameValueObject;
use Distribution\AcrissType\Domain\AcrissType;
use Distribution\AcrissType\Domain\AcrissTypeCollection;
use Distribution\AcrissType\Domain\AcrissTypeCriteria;
use Distribution\AcrissType\Domain\AcrissTypeGetByResponse;
use Distribution\AcrissType\Domain\AcrissTypeRepository;
use Shared\Domain\Criteria\FilterOperator;


/**
 * Class AcrissRepositoryFake
 * @package Distribution\Acriss\Infrastructure
 */
class AcrissTypeRepositoryFake implements AcrissTypeRepository
{
    /***
     * @var array
     */
    public array $acrissTypeList;
    /**
     * AcrissRepositoryFake constructor.
     */
    public function __construct()
    {
        $this->acrissTypeList = [];

        /*foreach (AcrissNameValueObject::$SECOND_ACRISS_LETTER_LIST as $key => $acrissLetter) {
            $this->acrissTypeList[] = [
                'id' => $key+1,
                'name' => AcrissNameValueObject::$SECOND_ACRISS_LETTER_NAMES[$key],
                'acrissLetter' => $acrissLetter,
            ];
        }*/
    }

    final public function getBy(AcrissTypeCriteria $criteria): ?AcrissTypeGetByResponse{


        $objectArray = $this->acrissTypeList;

        if($criteria->hasFilters()) {
            foreach ($criteria->getFilters(['id'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var $object AcrissType
                         */
                        return $object['id'] == $filter->getValue();
                    }
                );
            }
        }

        $acrissTypeCollection = new AcrissTypeCollection([]);
        foreach ($objectArray as $acrissType){
            $acrissTypeCollection->add(new AcrissType($acrissType['id'], $acrissType['name'], $acrissType['acrissLetter']));
        }
        return new AcrissTypeGetByResponse($acrissTypeCollection, $acrissTypeCollection->count());
    }

    final public function getById(int $id): ?AcrissType
    {
        $ret = null;
        // TODO fix this foreach
        foreach ($this->acrissTypeList as $acrissType){
            if($acrissType['id'] === $id){
                $ret = new AcrissType($acrissType['id'], $acrissType['name'], $acrissType['acrissLetter']);
            }
        }
        return $ret;
    }
}
