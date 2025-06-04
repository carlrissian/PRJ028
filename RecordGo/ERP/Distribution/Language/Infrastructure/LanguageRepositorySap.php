<?php
declare(strict_types=1);


namespace Distribution\Language\Infrastructure;



use Distribution\Language\Domain\Language;
use Distribution\Language\Domain\LanguageCollection;
use Distribution\Language\Domain\LanguageCriteria;
use Distribution\Language\Domain\LanguageGetByResponse;
use Distribution\Language\Domain\LanguageRepository;
use Shared\Domain\RequestHelper\SapRequestHelper;


class LanguageRepositorySap implements LanguageRepository
{
    private const PREFIX_FUNCTION_NAME = 'LanguageList/LanguageListRepository';

    /**
     * @param SapRequestHelper $sapRequestHelper
     */
    private SapRequestHelper $sapRequestHelper;

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        $this->sapRequestHelper = $sapRequestHelper;
    }


    public function getBy(LanguageCriteria $languageCriteria): LanguageGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $method = 'GET';

        $totalRows = 0;

        $collection  = new LanguageCollection([]);

        $body = json_encode([]);

        try{
            $response = $this->sapRequestHelper->request($method, $functionName, $body);

            if ($response === false) {
                throw new \Exception("The getBy request hasn't returned a response");
            }

            $responseArray = json_decode($response, true);

            $collectionArray = $responseArray['TLanguageListResponse'];

            foreach ($collectionArray as $itemArray) {
                $collection->add(new Language(intval($itemArray['ID']), $itemArray['LANGUAGESNAME'], $itemArray['LANGUAGESDESCRIPTION']));
            }

            $totalRows = $responseArray['TotalRows'];

        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new LanguageGetByResponse($collection, $totalRows);
    }

}