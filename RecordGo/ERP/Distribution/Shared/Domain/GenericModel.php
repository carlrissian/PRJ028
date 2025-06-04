<?php

declare(strict_types=1);

namespace Distribution\Shared\Domain;

use Shared\Utils\DataValidation;

class GenericModel
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
     * constructor.
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
     * @param array|null $genericModelArray
     * @return GenericModel
     */
    public static function createFromArray(?array $genericModelArray): GenericModel
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($genericModelArray, 'ID')),
            $helper->arrayExistOrNull($genericModelArray, 'MODELCODENAME')
        );
    }
}
