<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 09:36 AM
 */

namespace DbModels\Entities;

use DbModels\Mappings\StoreMapping;
use DbModels\Traits\BaseEntityFieldsTrait;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class Store
 * @package DbModels\Entities
 */
class Store
{
    use BaseEntityFieldsTrait;

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new StoreMapping;
        $builder($metadata);
    }

    /** @var null|int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $cityName = '';

    /** @var string */
    protected $address = '';

    /** @var null|string */
    protected $postalCode;

    /** @var null|string */
    protected $schedule;

    /** @var null|string */
    protected $sapCode;

    /** @var null|string */
    protected $type;

    /** @var State */
    protected $state;

    /** @var ChainStore */
    protected $chainStore;

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
     * @return string
     */
    public function getSapCode(): string
    {
        return $this->sapCode;
    }

    /**
     * @param string $name
     */
    public function setSapCode(?string $sapCode): void
    {
        $this->sapCode = $sapCode;
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityName;
    }

    /**
     * @param string $cityName
     */
    public function setCityName(string $cityName): void
    {
        $this->cityName = $cityName;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return null|string
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param null|string $postalCode
     */
    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return null|string
     */
    public function getSchedule(): ?string
    {
        return $this->schedule;
    }

    /**
     * @param null|string $schedule
     */
    public function setSchedule(?string $schedule): void
    {
        $this->schedule = $schedule;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return State
     */
    public function getState(): State
    {
        return $this->state;
    }

    /**
     * @param State $state
     */
    public function setState(State $state): void
    {
        $this->state = $state;
    }

    /**
     * @return ChainStore
     */
    public function getChainStore(): ChainStore
    {
        return $this->chainStore;
    }

    /**
     * @param ChainStore $chainStore
     */
    public function setChainStore(ChainStore $chainStore): void
    {
        $this->chainStore = $chainStore;
    }
}