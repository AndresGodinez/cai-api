<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 09:45 AM
 */

namespace DbModels\Entities;

use DbModels\Consts\InventoryEvidencePhotoType;
use DbModels\Mappings\InventoryEvidencePhotoMapping;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class InventoryEvidencePhoto
 * @package DbModels\Entities
 */
class InventoryEvidencePhoto
{
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new InventoryEvidencePhotoMapping;
        $builder($metadata);
    }

    /** @var null|int */
    protected $id;

    /** @var null|string */
    protected $filePath;

    /** @var int */
    protected $type = InventoryEvidencePhotoType::UNKNOWN;

    /** @var InventoryEvidence */
    protected $inventoryEvidence;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    /**
     * @param null|string $filePath
     */
    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return InventoryEvidence
     */
    public function getInventoryEvidence(): InventoryEvidence
    {
        return $this->inventoryEvidence;
    }

    /**
     * @param InventoryEvidence $inventoryEvidence
     */
    public function setInventoryEvidence(InventoryEvidence $inventoryEvidence): void
    {
        $this->inventoryEvidence = $inventoryEvidence;
    }
}