<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Domain;

class AcrissBranchTranslation
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var Branch
     */
    private Branch $branch;

    /**
     * @var bool
     */
    private bool $byDefault;

    /**
     * @var AcrissTranslationCollection|null
     */
    private ?AcrissTranslationCollection $acrissTranslations;

    /**
     * @var AcrissImageLineCollection|null
     */
    private ?AcrissImageLineCollection $acrissImageLines;

    /**
     * AcrissBranchTranslation constructor.
     *
     * @param integer|null $id
     * @param Branch $branch
     * @param boolean $byDefault
     * @param AcrissTranslationCollection|null $acrissTranslations
     * @param AcrissImageLineCollection|null $acrissImageLines
     */
    public function __construct(
        ?int $id,
        Branch $branch,
        bool $byDefault,
        ?AcrissTranslationCollection $acrissTranslations = null,
        ?AcrissImageLineCollection $acrissImageLines = null
    ) {
        $this->id = $id;
        $this->branch = $branch;
        $this->byDefault = $byDefault;
        $this->acrissTranslations = $acrissTranslations;
        $this->acrissImageLines = $acrissImageLines;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Branch
     */
    public function getBranch(): Branch
    {
        return $this->branch;
    }

    /**
     * @return bool
     */
    public function isByDefault(): bool
    {
        return $this->byDefault;
    }

    /**
     * @param bool $byDefault
     */
    public function setByDefault(bool $byDefault): void
    {
        $this->byDefault = $byDefault;
    }

    /**
     * @return AcrissTranslationCollection|null
     */
    public function getAcrissTranslations(): ?AcrissTranslationCollection
    {
        return $this->acrissTranslations;
    }

    /**
     * @return AcrissImageLineCollection|null
     */
    public function getAcrissImageLines(): ?AcrissImageLineCollection
    {
        return $this->acrissImageLines;
    }


    /**
     * @param array|null $acrissBranchTranslationArray
     * @return AcrissBranchTranslation
     */
    public static function createFromArray(?array $acrissBranchTranslationArray): AcrissBranchTranslation
    {
        $acrissTranslationCollection = new AcrissTranslationCollection([]);
        if (isset($acrissBranchTranslationArray['ACRISSBRANCHTRANSLATIONS'])) {
            foreach ($acrissBranchTranslationArray['ACRISSBRANCHTRANSLATIONS'] as $translation) {
                $acrissTranslationCollection->add(AcrissTranslation::createFromArray($translation));
            }
        }

        $acrissImageLineCollection = new AcrissImageLineCollection([]);
        if (isset($acrissBranchTranslationArray['ACRISSIMAGELINES'])) {
            foreach ($acrissBranchTranslationArray['ACRISSIMAGELINES'] as $imageLine) {
                $acrissImageLineCollection->add(AcrissImageLine::createFromArray($imageLine));
            }
        }

        return new self(
            intval($acrissBranchTranslationArray['ID']),
            (isset($acrissBranchTranslationArray['BRANCH'])) ? Branch::createFromArray($acrissBranchTranslationArray['BRANCH']) : null,
            filter_var($acrissBranchTranslationArray['BYDEFAULT'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            $acrissTranslationCollection,
            $acrissImageLineCollection
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $acrissTranslationsArray = [];
        if (!empty($this->getAcrissTranslations())) {
            /**
             * @var AcrissTranslation $translation
             */
            foreach ($this->getAcrissTranslations() as $translation) {
                $acrissTranslationsArray[] = $translation->toArray();
            }
        }

        $acrissImageLineArray = [];
        if (!empty($this->getAcrissImageLines())) {
            /**
             * @var AcrissImageLine $imageLine
             */
            foreach ($this->getAcrissImageLines() as $imageLine) {
                $acrissImageLineArray[] = $imageLine->toArray();
            }
        }

        return [
            'ID' => $this->getId(),
            'BRANCHID' => $this->getBranch()->getId(),
            'BYDEFAULT' => $this->isByDefault(),
            'ACRISSBRANCHTRANSLATIONS' => $acrissTranslationsArray,
            'ACRISSIMAGELINES' => $acrissImageLineArray,
        ];
    }
}
