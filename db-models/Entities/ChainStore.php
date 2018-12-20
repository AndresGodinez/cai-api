<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 09:35 AM
 */

namespace DbModels\Entities;

use DbModels\Mappings\ChainStoreMapping;
use DbModels\Traits\BaseEntityFieldsTrait;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class ChainStore
 * @package DbModels\Entities
 */
class ChainStore
{
    use BaseEntityFieldsTrait;

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ChainStoreMapping;
        $builder($metadata);
    }

    /** @var null|int */
    protected $id;

    /** @var string */
    protected $name;

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
}