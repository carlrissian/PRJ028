<?php

declare(strict_types=1);

namespace Distribution\BusinessUnitArticle\Infrastructure;

use Closure;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticle;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleCollection;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleCriteria;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleGetByResponse;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleRepository;
use Exception;
use Shared\Repository\RepositoryHelper;
use Shared\Domain\RequestHelper\SapRequestHelper;

class BusinessUnitArticleRepositorySap extends RepositoryHelper implements BusinessUnitArticleRepository
{
    const PREFIX_FUNCTION_NAME = 'SAPArticle/SAPArticleRepository';

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(BusinessUnitArticleCriteria $criteria): BusinessUnitArticleGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new BusinessUnitArticleCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TSAPArticleResponse', $collection, Closure::fromCallable([$this, 'arrayToBusinessUnitArticle']));

            return new BusinessUnitArticleGetByResponse($collection, $totalRows);

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }



    final public function arrayToBusinessUnitArticle(array $businessUnitArticleArray): BusinessUnitArticle
    {
        return BusinessUnitArticle::createFromArray($businessUnitArticleArray);
    }
}
