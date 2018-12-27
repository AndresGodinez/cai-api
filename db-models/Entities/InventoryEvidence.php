<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 09:44 AM
 */

namespace DbModels\Entities;

use DbModels\Mappings\InventoryEvidenceMapping;
use DbModels\Traits\BaseEntityFieldsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class InventoryEvidence
 * @package DbModels\Entities
 */
class InventoryEvidence
{
    use BaseEntityFieldsTrait;

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new InventoryEvidenceMapping;
        $builder($metadata);
    }

    /** @var null|int */
    protected $id;

    /** @var string */
    protected $code;

    /** @var null|string */
    protected $comments;

    /** @var Store */
    protected $store;

    /** @var Brand */
    protected $brand;

    /** @var FurnitureType */
    protected $furnitureType;

    /** @var Clerk */
    protected $clerk;

    /** @var User */
    protected $user;

    /** @var ArrayCollection */
    protected $photos;

    /**
     * InventoryEvidence constructor.
     */
    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    /**
     * @param InventoryEvidencePhoto $photo
     * @return bool
     */
    public function addPhoto(InventoryEvidencePhoto $photo)
    {
        if (!$this->photos) {
            $this->photos = new ArrayCollection();
        }

        $photo->setInventoryEvidence($this);

        return $this->photos->add($photo);
    }

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
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return null|string
     */
    public function getComments(): ?string
    {
        return $this->comments;
    }

    /**
     * @param null|string $comments
     */
    public function setComments(?string $comments): void
    {
        $this->comments = $comments;
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

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}