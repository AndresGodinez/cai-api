<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 6/01/19
 * Time: 01:47 PM
 */

namespace DbModels\Entities;

use DbModels\Mappings\BrandFurnitureTypeMapping;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class BrandFurnitureType
 * @package DbModels\Entities
 */
class BrandFurnitureType
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new BrandFurnitureTypeMapping;
        $builder($metadata);
    }

    /** @var null|int */
    protected $id;

    /** @var Brand */
    protected $brand;

    /** @var FurnitureType */
    protected $furnitureType;

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
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     */
    public function setBrand(Brand $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return FurnitureType
     */
    public function getFurnitureType(): FurnitureType
    {
        return $this->furnitureType;
    }

    /**
     * @param FurnitureType $furnitureType
     */
    public function setFurnitureType(FurnitureType $furnitureType): void
    {
        $this->furnitureType = $furnitureType;
    }
}