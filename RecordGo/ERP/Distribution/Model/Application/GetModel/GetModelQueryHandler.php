<?php
declare(strict_types=1);


namespace Distribution\Model\Application\GetModel;


use Distribution\Model\Domain\ModelCollection;
use Distribution\Model\Domain\ModelCriteria;
use Distribution\Model\Domain\ModelRepository;

class GetModelQueryHandler
{
    /**
     * @var ModelRepository
     */
    private ModelRepository $modelRepository;

    /**
     * GetModelQueryHandler constructor.
     * @param ModelRepository $modelRepository
     */
    public function __construct(ModelRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    public function handle(GetModelQuery $getModelQuery): GetModelQueryHandlerResponse
    {
        $response = $this->modelRepository->getBy(new ModelCriteria());

        return new GetModelQueryHandlerResponse(new ModelCollection($response->getData()), $response->getTotalRows());
    }

}