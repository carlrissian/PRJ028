<?php

declare(strict_types=1);


namespace Distribution\Movement\Domain;

class BusinessUnitArticle
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * BusinessUnitArticle constructor.
     * 
     * @param string $id
     * @param string|null $name
     */
    public function __construct(
        string $id,
        ?string $name = null
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    final public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array|null $businessunitArticleArray
     * @return self
     */
    public static function createFromArray(?array $businessunitArticleArray): self
    {
        return new self(
            $businessunitArticleArray['ID'],
            $businessunitArticleArray['ITEMNAME']
        );
    }
}
