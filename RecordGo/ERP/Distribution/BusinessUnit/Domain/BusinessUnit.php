<?php

declare(strict_types=1);


namespace Distribution\BusinessUnit\Domain;

use Shared\Utils\DataValidation;

class BusinessUnit
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private ?string $name;

    /**
     * BusinessUnit constructor.
     *
     * @param string $id
     * @param string|null $name
     */
    public function __construct(string $id,  ?string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param array|null $businessunitArray
     * @return BusinessUnit
     */
    public static function createFromArray(?array $businessunitArray): BusinessUnit
    {
        return new self(
            $businessunitArray['CenterCode'],
            $businessunitArray['CenterName']
        );
    }
}
