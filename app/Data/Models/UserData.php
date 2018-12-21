<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 21/12/18
 * Time: 04:54 PM
 */

namespace App\Data\Models;

use DbModels\Entities\User;

/**
 * Class UserData
 * @package App\Data\Models
 */
class UserData
{
    /** @var User */
    protected $user;

    /** @var array */
    protected $userData;

    /**
     * @return array
     */
    public function getStatesData()
    {
        $states = [];

        $length = \count($this->userData);

        for ($i = 0; $i < $length; $i++) {
            $item = $this->userData[$i];

            if (!\array_key_exists($item['stateId'], $states)) {
                $states[$item['stateId']] = [
                    'id' => (int)$item['stateId'],
                    'name' => $item['stateName'],
                    'code' => $item['stateCode'],
                    'shops' => [],
                ];
            }

            \array_push($states[$item['stateId']]['shops'], [
                'id' => (int)$item['storeId'],
                'name' => $item['storeName'],
            ]);
        }

        return \array_values($states);
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

    /**
     * @return array
     */
    public function getUserData(): array
    {
        return $this->userData;
    }

    /**
     * @param array $userData
     */
    public function setUserData(array $userData): void
    {
        $this->userData = $userData;
    }
}