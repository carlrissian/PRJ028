<?php

declare(strict_types=1);

namespace Distribution\Brand\Infrastructure;

use Closure;
use Exception;
use Distribution\Brand\Domain\Brand;
use Shared\Repository\RepositoryHelper;
use Distribution\Brand\Domain\BrandCriteria;
use Distribution\Brand\Domain\BrandCollection;
use Distribution\Brand\Domain\BrandRepository;
use Distribution\Brand\Domain\BrandGetByResponse;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Shared\Utils\Utils;

class BrandRepositorySap implements BrandRepository
{
    public const PREFIX_FUNCTION_NAME = 'Brand/BrandRepository';

    /**
     * @var SapRequestHelper
     */
    protected SapRequestHelper $sapRequestHelper;

    /**
     * @param SapRequestHelper $sapRequestHelper
     */
    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        $this->sapRequestHelper = $sapRequestHelper;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(BrandCriteria $criteria): BrandGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new BrandCollection([]);

        try {
            $body = json_encode(Utils::createCriteria($criteria));

            $response = $this->sapRequestHelper->request('GET', $functionName, $body);
            $responseArray = json_decode($response, true);

            foreach($responseArray['TBrandResponse'] as $brandArray) {
                $collection->add($this->arrayToBrand($brandArray));
            }
            $totalRows = $responseArray['TotalRows'] ?? 0;

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return new BrandGetByResponse($collection, $totalRows);

    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getById(int $id): ?Brand
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $response = $this->sapRequestHelper->request('GET', $functionName,  '');
            $responseArray = json_decode($response, true);

            return Brand::createFromArray($responseArray['TBrandResponse']);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    final private function arrayToBrand(array $brandArray): Brand
    {
        return Brand::createFromArray($brandArray);
    }
}
