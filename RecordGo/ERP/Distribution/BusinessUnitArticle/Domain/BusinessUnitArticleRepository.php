<?php
declare(strict_types=1);


namespace Distribution\BusinessUnitArticle\Domain;


interface BusinessUnitArticleRepository
{
    /**
     * @param BusinessUnitArticleCriteria $businessUnitArticleCriteria
     * @return BusinessUnitArticleGetByResponse
     */
    public function getBy(BusinessUnitArticleCriteria $businessUnitArticleCriteria): BusinessUnitArticleGetByResponse;
}