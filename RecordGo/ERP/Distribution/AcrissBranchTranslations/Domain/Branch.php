<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Domain;

use Shared\Utils\DataValidation;

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
    public function __construct(
        int $id,
        ?string $name = null,
        ?string $branchIATA = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->branchIATA = $branchIATA;
    }

    /**
     * Get the value of id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * Get the value of name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the value of branchIATA
     *
     * @return string|null
     */
    public function getBranchIATA(): ?string
    {
        return $this->branchIATA;
    }


    /**
     * @param array|null $branchArray
     * @return Branch
     */
    public static function createFromArray(?array $branchArray): Branch
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($branchArray, 'ID')),
            $helper->arrayExistOrNull($branchArray, 'BRANCHINTNAME'),
            $helper->arrayExistOrNull($branchArray, 'BRANCHIATA')
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
