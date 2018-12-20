<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 09:42 AM
 */

namespace DbModels\Entities;

use DbModels\Mappings\StoreBrandMapping;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class StoreBrand
 * @package DbModels\Entities
 */
class StoreBrand
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new StoreBrandMapping;
        $builder($metadata);
    }

    /** @var null|int */
    protected $id;

    /** @var Store */
    protected $store;

    /** @var Brand */
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
     * @return Store
     */
    public function getStore(): Store
    {
        return $this->store;
    }

    /**
     * @param Store $store
     */
    public function setStore(Store $store): void
    {
        $this->store = $store;
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
}