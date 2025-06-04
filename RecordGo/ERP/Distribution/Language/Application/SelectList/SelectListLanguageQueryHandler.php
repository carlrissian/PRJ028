<?php

declare(strict_types=1);

namespace Distribution\Language\Application\SelectList;

use Shared\Domain\Criteria\FilterCollection;
use Distribution\Language\Domain\LanguageCriteria;
use Distribution\Language\Domain\LanguageRepository;
use Shared\Utils\Utils;

class SelectListLanguageQueryHandler
{
    /**
     * @var LanguageRepository
     */
    private LanguageRepository $languageRepository;

    /**
     * @param LanguageRepository $languageRepository
     */
    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * @return SelectListLanguageResponse
     */
    public function handle(): SelectListLanguageResponse
    {
        $languageCollection = $this->languageRepository->getBy(new LanguageCriteria(new FilterCollection([])))->getCollection();
        return new  SelectListLanguageResponse(Utils::createCustomSelectList($languageCollection, 'id', 'name', 'code'));
    }
}
