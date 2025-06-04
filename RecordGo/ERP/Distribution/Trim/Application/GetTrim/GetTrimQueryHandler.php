<?php
declare(strict_types=1);


namespace Distribution\Trim\Application\GetTrim;


use Distribution\Trim\Domain\TrimCriteria;
use Distribution\Trim\Domain\TrimNotFoundException;
use Distribution\Trim\Domain\TrimRepository;

class GetTrimQueryHandler
{
    /**
     * @var TrimRepository
     */
    private TrimRepository $trimRepository;

    /**
     * GetTrimHandler constructor.
     * @param TrimRepository $trimRepository
     */
    public function __construct(TrimRepository $trimRepository)
    {
        $this->trimRepository = $trimRepository;
    }

    /**
     * @throws TrimNotFoundException
     */
    public function handle(GetTrimQuery $query): GetTrimResponse
    {
        $trimCollection = $this->trimRepository->getBy(new TrimCriteria())->getCollection();
        if (empty( $trimCollection ) ){
            throw new TrimNotFoundException('Error getting trimCollection');
        }
        $trimList = [];
        foreach ($trimCollection as $trim){
            $trimList[] = [
                'id' =>   $trim->getId(),
                'name' => $trim->getName()
            ];
        }
        return new GetTrimResponse($trimList);
    }
}