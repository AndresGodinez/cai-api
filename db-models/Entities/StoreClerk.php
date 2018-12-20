<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 09:43 AM
 */

namespace DbModels\Entities;

use DbModels\Mappings\StoreClerkMapping;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class StoreClerk
 * @package DbModels\Entities
 */
class StoreClerk
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new StoreClerkMapping;
        $builder($metadata);
    }

    /** @var null|int */
    protected $id;

    /** @var Store */
    protected $store;

    /** @var Clerk */
    protected $clerk;

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
     * @return Clerk
     */
    public function getClerk(): Clerk
    {
        return $this->clerk;
    }

    /**
     * @param Clerk $clerk
     */
    public function setClerk(Clerk $clerk): void
    {
        $this->clerk = $clerk;
    }
}