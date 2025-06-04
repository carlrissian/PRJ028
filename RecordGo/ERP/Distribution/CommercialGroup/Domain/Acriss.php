<?php

namespace Distribution\CommercialGroup\Domain;

use Shared\Utils\DataValidation;

class Acriss
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * constructor
     *
     * @param integer $id
     * @param string|null $name
     */
    public function __construct(int $id, ?string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int
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
     * @param array|null $acrissArray
     * @return Acriss
     */
    public static function createFromArray(?array $acrissArray): Acriss
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($acrissArray, 'ID')),
            $helper->arrayExistOrNull($acrissArray, 'NAME')
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'NAME' => $this->getName()
        ];
    }
}
