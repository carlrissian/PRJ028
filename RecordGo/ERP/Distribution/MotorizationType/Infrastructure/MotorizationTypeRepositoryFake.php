<?php
declare(strict_types=1);

namespace Distribution\MotorizationType\Infrastructure;


use Distribution\Acriss\Domain\AcrissNameValueObject;
use Distribution\MotorizationType\Domain\MotorizationType;
use Distribution\MotorizationType\Domain\MotorizationTypeCollection;
use Distribution\MotorizationType\Domain\MotorizationTypeCriteria;
use Distribution\MotorizationType\Domain\MotorizationTypeGetByResponse;
use Distribution\MotorizationType\Domain\MotorizationTypeRepository;


class MotorizationTypeRepositoryFake implements MotorizationTypeRepository
{
    /**
     * @var array
     */
    public array $motorizationTypeList;

    public function __construct()
    {
        foreach (AcrissNameValueObject::$FOURTH_ACRISS_LETTER_LIST as $key => $acrissLetter) {
            $this->motorizationTypeList[] = [
                'id' => $key+1,
                'name' => AcrissNameValueObject::$FOURTH_ACRISS_LETTER_NAMES[$key],
                'acrissLetter' => $acrissLetter,
            ];
        }
    }

    public function getBy(MotorizationTypeCriteria $motorizationTypeCriteria): MotorizationTypeGetByResponse
    {
            $motorizationTypeCollection = new MotorizationTypeCollection([]);
            foreach ($this->motorizationTypeList as $motorizationType){
                $motorizationTypeCollection->add(new MotorizationType($motorizationType['id'], $motorizationType['name'], $motorizationType['acrissLetter']));
            }

        return new MotorizationTypeGetByResponse($motorizationTypeCollection, $motorizationTypeCollection->count());
    }

    public function getById(int $id): ?MotorizationType
    {
        $ret = null;
        // TODO fix foreach
        foreach ($this->motorizationTypeList as $motorizationType){
            if($motorizationType['id'] === $id){
                $ret = new MotorizationType($motorizationType['id'], $motorizationType['name'], $motorizationType['acrissLetter']);
            }
        }
        return $ret;
    }
}
