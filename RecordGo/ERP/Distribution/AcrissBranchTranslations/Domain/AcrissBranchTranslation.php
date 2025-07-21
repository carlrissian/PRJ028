<?php

namespace Distribution\AcrissBranchTranslations\Domain;

final class AcrissBranchTranslation
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
     * @var bool|null
     */
    private ?bool $byDefault;

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
     * @param bool|null $byDefault
     * @param AcrissTranslationCollection|null $acrissTranslations
     * @param AcrissImageLineCollection|null $acrissImageLines
     */
    private function __construct(
        ?int $id,
        Branch $branch,
        ?bool $byDefault,
        ?AcrissTranslationCollection $acrissTranslations,
        ?AcrissImageLineCollection $acrissImageLines
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
     * @return bool|null
     */
    public function isByDefault(): ?bool
    {
        return $this->byDefault;
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
     * @param integer|null $id
     * @param Branch $branch
     * @param boolean $byDefault
     * @param AcrissTranslationCollection|null $acrissTranslations
     * @param AcrissImageLineCollection|null $acrissImageLines
     */
    public static function create(
        ?int $id,
        Branch $branch,
        bool $byDefault,
        ?AcrissTranslationCollection $acrissTranslations = null,
        ?AcrissImageLineCollection $acrissImageLines = null
    ): self {
        return new self(
            $id,
            $branch,
            $byDefault,
            $acrissTranslations,
            $acrissImageLines
        );
    }

    /**
     * @param array|null $acrissBranchTranslationArray
     * @return self
     */
    public static function createFromArray(?array $acrissBranchTranslationArray): self
    {
        return self::create(
            intval($acrissBranchTranslationArray['ID']),
            isset($acrissBranchTranslationArray['BRANCH']) ? Branch::createFromArray($acrissBranchTranslationArray['BRANCH']) : null,
            isset($acrissBranchTranslationArray['BYDEFAULT']) ? filter_var($acrissBranchTranslationArray['BYDEFAULT'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null,
            AcrissTranslationCollection::createFromArray($acrissBranchTranslationArray['ACRISSBRANCHTRANSLATIONS']),
            AcrissImageLineCollection::createFromArray($acrissBranchTranslationArray['ACRISSIMAGELINES'])
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
