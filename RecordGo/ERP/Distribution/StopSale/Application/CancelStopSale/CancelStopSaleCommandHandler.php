<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\CancelStopSale;

use Exception;
use Distribution\StopSale\Domain\StopSaleRepository;

class CancelStopSaleCommandHandler
{
    /**
     * @var StopSaleRepository
     */
    private StopSaleRepository $stopSaleRepository;

    /**
     * CancelStopSaleCommandHandler constructor.
     * 
     * @param StopSaleRepository $stopSaleRepository
     */
    public function __construct(StopSaleRepository $stopSaleRepository)
    {
        $this->stopSaleRepository = $stopSaleRepository;
    }


    /**
     * @throws Exception
     */
    final public function handle(CancelStopSaleCommand $command): CancelStopSaleResponse
    {
        $stopSale = $this->stopSaleRepository->getById($command->getId());

        $stopSale->setCancelled();

        $updated = $this->stopSaleRepository->update($stopSale);

        return new CancelStopSaleResponse($updated ? true : false);
    }
}
