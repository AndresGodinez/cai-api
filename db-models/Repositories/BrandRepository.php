<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:45 AM
 */

namespace DbModels\Repositories;

use DbModels\Consts\DefaultEntityRegStatus;
use Doctrine\ORM\EntityRepository;

/**
 * Class BrandRepository
 * @package DbModels\Repositories
 */
class BrandRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function getValidRegisters()
    {
        return $this->findBy(['regStatus' => DefaultEntityRegStatus::ACTIVE]);
    }
}