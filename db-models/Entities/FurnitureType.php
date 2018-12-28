<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 09:31 AM
 */

namespace DbModels\Entities;

use DbModels\Mappings\FurnitureTypeMapping;
use DbModels\Traits\BaseEntityFieldsTrait;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class FurnitureType
 * @package DbModels\Entities
 */
class FurnitureType
{
    use BaseEntityFieldsTrait;

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new FurnitureTypeMapping;
        $builder($metadata);
    }

    /** @var null|int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var null|string */
    protected $description;

    /** @var null|Brand */
    protected $brand;

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Brand|null
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand|null $brand
     */
    public function setBrand(?Brand $brand): void
    {
        $this->brand = $brand;
    }
}