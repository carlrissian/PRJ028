<?php

declare(strict_types=1);


namespace Distribution\BusinessUnitArticle\Domain;

use Shared\Utils\DataValidation;

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
     * @var MovementTypeCollection|null
     */
    private ?MovementTypeCollection $movementTypeCollection;

    /**
     * BusinessUnitArticle constructor.
     * @param string $id
     * @param string|null $name
     * @param MovementTypeCollection|null $movementTypeCollection
     */
    public function __construct(
        string $id,
        ?string $name = null,
        ?MovementTypeCollection $movementTypeCollection = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->movementTypeCollection = $movementTypeCollection;
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
     * @return MovementTypeCollection|null
     */
    final public function getMovementTypeCollection(): ?MovementTypeCollection
    {
        return $this->movementTypeCollection;
    }


    /**
     * @param array|null $businessunitArticleArray
     * @return BusinessUnitArticle
     */
    public static function createFromArray(?array $businessunitArticleArray): BusinessUnitArticle
    {
        return new self(
            $businessunitArticleArray['ItemCode'],
            $businessunitArticleArray['ItemName'],
            // TODO MovementTypeCollection
            null
        );
    }
}
