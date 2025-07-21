<?php

namespace Distribution\AcrissBranchTranslations\Domain;

final class Branch
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;


    /**
     * @var string|null
     */
    private ?string $branchIATA;

    /**
     * Branch constructor
     *
     * @param integer $id
     * @param string|null $name
     * @param string|null $branchIATA
     */
    private function __construct(
        int $id,
        ?string $name,
        ?string $branchIATA
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->branchIATA = $branchIATA;
    }

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getBranchIATA(): ?string
    {
        return $this->branchIATA;
    }


    /**
     * @param integer $id
     * @param string|null $name
     * @param string|null $branchIATA
     */
    public static function create(
        int $id,
        ?string $name = null,
        ?string $branchIATA = null
    ): self {
        return new self(
            $id,
            $name,
            $branchIATA
        );
    }

    /**
     * @param array|null $branchArray
     * @return self
     */
    public static function createFromArray(?array $branchArray): self
    {
        return self::create(
            intval($branchArray['ID']),
            $branchArray['BRANCHINTNAME'] ?? null,
            $branchArray['BRANCHIATA'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'BRANCHINTNAME' => $this->getName(),
            'BRANCHIATA' => $this->getBranchIATA(),
        ];
    }
}
