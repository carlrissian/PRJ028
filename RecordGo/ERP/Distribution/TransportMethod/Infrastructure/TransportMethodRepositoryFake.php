<?php
declare(strict_types=1);


namespace Distribution\TransportMethod\Infrastructure;

use Distribution\TransportMethod\Domain\TransportMethod;
use Distribution\TransportMethod\Domain\TransportMethodCollection;
use Distribution\TransportMethod\Domain\TransportMethodCriteria;
use Distribution\TransportMethod\Domain\TransportMethodGetByResponse;
use Distribution\TransportMethod\Domain\TransportMethodRepository;


class TransportMethodRepositoryFake implements TransportMethodRepository
{
    /**
     * @var array
     */
    public array $transportMethodList;

    public function __construct()
    {
        $this->transportMethodList = [
            ['id' => 1,  'name' => 'Marítimo'],
            ['id' => 2,  'name' => 'Carretera'],

        ];

    }

    public function getBy(TransportMethodCriteria $transportMethodCriteria): TransportMethodGetByResponse
    {
        $objectArray = [];
        foreach ($this->transportMethodList as $transportMethod){
            $objectArray[] = new TransportMethod($transportMethod['id'], $transportMethod['name']);
        }

        $transportMethodCollection = new TransportMethodCollection($objectArray);

        return new TransportMethodGetByResponse($transportMethodCollection, $transportMethodCollection->count());
    }

}