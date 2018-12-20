<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 09:32 AM
 */

namespace DbModels\Entities;

use DbModels\Mappings\LineMapping;
use DbModels\Traits\BaseEntityFieldsTrait;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class Line
 * @package DbModels\Entities
 */
class Line
{
    use BaseEntityFieldsTrait;

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new LineMapping;
        $builder($metadata);
    }

    /** @var null|int */
    protected $id;

    /** @var string */
    protected $name;

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