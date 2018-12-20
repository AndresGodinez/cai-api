<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 09:26 AM
 */

namespace DbModels\Entities;

use DbModels\Consts\UserType;
use DbModels\Mappings\UserMapping;
use DbModels\Traits\BaseEntityFieldsTrait;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class User
 * @package DbModels\Entities
 */
class User
{
    use BaseEntityFieldsTrait;

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new UserMapping;
        $builder($metadata);
    }

    /** @var null|int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $username;

    /** @var null|string */
    protected $pswd;

    /** @var int */
    protected $type = UserType::UNKNOWN;

    /** @var null|Clerk */
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return null|string
     */
    public function getPswd(): ?string
    {
        return $this->pswd;
    }

    /**
     * @param null|string $pswd
     */
    public function setPswd(?string $pswd): void
    {
        $this->pswd = $pswd;
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
     * @return Clerk|null
     */
    public function getClerk(): ?Clerk
    {
        return $this->clerk;
    }

    /**
     * @param Clerk|null $clerk
     */
    public function setClerk(?Clerk $clerk): void
    {
        $this->clerk = $clerk;
    }
}