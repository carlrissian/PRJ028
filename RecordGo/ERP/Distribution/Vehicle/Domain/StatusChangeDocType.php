<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

class StatusChangeDocType
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
     * @var int
     */
    private int $documentTypeId;

    /**
     * @param int $id
     * @param string $name
     * @param int $documentTypeId
     */
    public function __construct(int $id, string $name, int $documentTypeId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->documentTypeId = $documentTypeId;
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
     * @return int
     */
    public function getDocumentTypeId(): int
    {
        return $this->documentTypeId;
    }


    /**
     * @param array|null $statusChangeDocTypeArray
     * @return self
     */
    public static function createFromArray(?array $statusChangeDocTypeArray): self
    {
        return new self(
            intval($statusChangeDocTypeArray['ID']),
            $statusChangeDocTypeArray['NAME'] ?? null,
            isset($statusChangeDocTypeArray['DOCUMENTTYPEID']) ? intval($statusChangeDocTypeArray['DOCUMENTTYPEID']) : null
        );
    }
}
