<?php

declare(strict_types=1);

namespace Distribution\Language\Domain;

class Language
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;
    
    /**
     * @var string
     */
    private string $code;

    /**
     * @param int $id
     * @param string $name
     * @param string $code
     */
    public function __construct(int $id, string $name, string $code)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getId(): int
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
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}
