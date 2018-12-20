<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 29/11/18
 * Time: 02:29 PM
 */

namespace DbModels\Traits;

use DbModels\Consts\DefaultEntityRegStatus;

/**
 * Trait BaseEntityFieldsTrait
 * @package DbModels\Traits
 */
trait BaseEntityFieldsTrait
{
    /** @var null|\DateTime */
    protected $regCreatedDt = null;

    /** @var null|\DateTime */
    protected $regUpdatedDt = null;

    /** @var int */
    protected $regStatus = DefaultEntityRegStatus::ACTIVE;

    /**
     * @return \DateTime|null
     */
    public function getRegCreatedDt(): ?\DateTime
    {
        return $this->regCreatedDt;
    }

    /**
     * @param \DateTime|null $regCreatedDt
     */
    public function setRegCreatedDt(?\DateTime $regCreatedDt): void
    {
        $this->regCreatedDt = $regCreatedDt;
    }

    /**
     * @return \DateTime|null
     */
    public function getRegUpdatedDt(): ?\DateTime
    {
        return $this->regUpdatedDt;
    }

    /**
     * @param \DateTime|null $regUpdatedDt
     */
    public function setRegUpdatedDt(?\DateTime $regUpdatedDt): void
    {
        $this->regUpdatedDt = $regUpdatedDt;
    }

    /**
     * @return int
     */
    public function getRegStatus(): int
    {
        return $this->regStatus;
    }

    /**
     * @param int $regStatus
     */
    public function setRegStatus(int $regStatus): void
    {
        $this->regStatus = $regStatus;
    }
}