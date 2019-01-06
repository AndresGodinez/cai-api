<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:29 AM
 */

namespace DbModels\Repositories;

use DbModels\Consts\DefaultEntityRegStatus;
use Doctrine\ORM\EntityRepository;

/**
 * Class FurnitureTypeRepository
 * @package DbModels\Repositories
 */
class FurnitureTypeRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function getValidRegisters()
    {
        return $this->findBy(['regStatus' => DefaultEntityRegStatus::ACTIVE]);
    }
}