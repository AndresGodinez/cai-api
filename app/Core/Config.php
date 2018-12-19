<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 16/10/18
 * Time: 11:51 AM
 */

namespace App\Core;

use App\Exceptions\InternalException;

/**
 * Class Config
 * @package App\Core
 */
class Config
{
    /** @var array */
    private $data;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     * @throws InternalException
     */
    public function get(string $key, $default = null)
    {
        $this->validate();

        if (!\key_exists($key, $this->data)) {
            return $default;
        }

        return $this->data[$key];
    }

    /**
     * @return bool
     * @throws InternalException
     */
    private function validate()
    {
        if (!$this->data) {
            throw new InternalException('Invalid configuration');
        }

        return true;
    }
}