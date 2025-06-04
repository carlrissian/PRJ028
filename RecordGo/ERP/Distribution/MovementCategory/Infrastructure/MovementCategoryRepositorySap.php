<?php
declare(strict_types=1);


namespace Distribution\MovementCategory\Infrastructure;


use Closure;
use Distribution\MovementCategory\Domain\MovementCategory;
use Distribution\MovementCategory\Domain\MovementCategoryCollection;
use Distribution\MovementCategory\Domain\MovementCategoryCriteria;
use Distribution\MovementCategory\Domain\MovementCategoryGetByResponse;
use Distribution\MovementCategory\Domain\MovementCategoryRepository;
use Exception;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Shared\Repository\RepositoryHelper;
use Shared\Utils\Utils;

class MovementCategoryRepositorySap extends RepositoryHelper implements  MovementCategoryRepository
{
    private const PREFIX_FUNCTION_NAME = 'MovementCategory/MovementCategoryRepository';

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(MovementCategoryCriteria $criteria): MovementCategoryGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new MovementCategoryCollection([]);

        try {
            $body = json_encode(Utils::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TMovementCategoryResponse', $collection, Closure::fromCallable([$this, 'arrayToMovementCategory']));

            return new MovementCategoryGetByResponse($collection, $totalRows);

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }



    final public function arrayToMovementCategory(array $movementCategoryArray): MovementCategory
    {
        return MovementCategory::createFromArray($movementCategoryArray);
    }
}