<?php

namespace Distribution\BusinessUnitArticle\Application\SelectList;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleCriteria;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleRepository;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;

class SelectListBusinessUnitArticleQueryHandler
{
    /**
     * @var BusinessUnitArticleRepository
     */
    private $businessUnitArticleRepository;

    /**
     * SelectListBusinessUnitArticleQueryHandler constructor.
     *
     * @param BusinessUnitArticleRepository $businessUnitArticleRepository
     */
    public function __construct(BusinessUnitArticleRepository $businessUnitArticleRepository)
    {
        $this->businessUnitArticleRepository = $businessUnitArticleRepository;
    }

    /**
     * @return SelectListBusinessUnitArticleResponse
     */
    public function handle(SelectListBusinessUnitArticleQuery $query): SelectListBusinessUnitArticleResponse
    {
        $criteria = $this->setCriteria($query);
        $businessUnitArticleCollection = $this->businessUnitArticleRepository->getBy($criteria)->getCollection();
        return new SelectListBusinessUnitArticleResponse(Utils::createSelect($businessUnitArticleCollection));
    }


    /**
     * @param SelectListBusinessUnitArticleQuery $query
     * @return BusinessUnitArticleCriteria
     */
    private function setCriteria(SelectListBusinessUnitArticleQuery $query): BusinessUnitArticleCriteria
    {
        $filterCollection = new FilterCollection([]);

        if (!empty($query->getMovementTypeId())) {
            switch ($query->getMovementTypeId()) {
                case ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER'):
                    $subfamilia = ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_U_EXO_SUBFAMILIA_CARRIER');
                    break;
                case ConstantsJsonFile::getValue('TRANSPORTTYPE_OPERATION'):
                    $subfamilia = ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_U_EXO_SUBFAMILIA_OPERATION');
                    break;
                case ConstantsJsonFile::getValue('TRANSPORTTYPE_DRIVER'):
                default:
                    $subfamilia = ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_U_EXO_SUBFAMILIA_DRIVER');
                    break;
            }

            $filterCollection->add(new Filter('U_EXO_SUBFAMILIA', new FilterOperator(FilterOperator::EQUAL), $subfamilia));
        }


        $criteria = new BusinessUnitArticleCriteria($filterCollection);

        return $criteria;
    }
}
