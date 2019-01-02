<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 2/01/19
 * Time: 05:10 PM
 */

namespace DbModels\Entities;

use DbModels\Mappings\InventoryCodeMapping;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class InventoryCode
 * @package DbModels\Entities
 */
class InventoryCode
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new InventoryCodeMapping;
        $builder($metadata);
    }

    /** @var null|int */
    protected $id;

    /** @var string */
    protected $code;

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
}