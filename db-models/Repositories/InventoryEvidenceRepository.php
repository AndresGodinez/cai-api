<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 01:07 PM
 */

namespace DbModels\Repositories;

use DbModels\Consts\DefaultEntityRegStatus;
use Doctrine\ORM\EntityRepository;

/**
 * Class InventoryEvidenceRepository
 * @package DbModels\Repositories
 */
class InventoryEvidenceRepository extends EntityRepository
{
    /**
     * @param int $userId
     * @return array
     */
    public function getValidRegistersFromUserId(int $userId)
    {
        return $this->findBy(['user' => $userId, 'regStatus' => DefaultEntityRegStatus::ACTIVE]);
    }
}