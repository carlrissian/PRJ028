<?php

namespace Distribution\Movement\Application\UpdateDeliveryNotes;

class UpdateDeliveryNotesMovementCommand
{
    /**
     * @var int
     */
    private $movementId;

    /**
     * @var int|null
     */
    private $id;

    /**
     * @var int
     */
    private $typeId;

    /**
     * @var string
     */
    private $typeName;

    /**
     * @var string
     */
    private $file;

    /**
     * UpdateDeliveryNotesMovementCommand constructor.
     *
     * @param int $movementId
     * @param integer|null $id
     * @param integer $typeId
     * @param string $typeName
     * @param string $file
     */
    public function __construct(
        int $movementId,
        ?int $id,
        int $typeId,
        string $typeName,
        string $file
    ) {
        $this->movementId = $movementId;
        $this->id = $id;
        $this->typeId = $typeId;
        $this->typeName = $typeName;
        $this->file = $file;
    }

    /**
     * @return int
     */
    public function getMovementId(): int
    {
        return $this->movementId;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTypeId(): int
    {
        return $this->typeId;
    }

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        return $this->typeName;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }
}
