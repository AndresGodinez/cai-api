<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 29/11/18
 * Time: 03:15 PM
 */

namespace Tests;

use App\Core\AppContainer;

/**
 * Trait ConfigurableConnectionTestTrait
 * @package Tests
 */
trait ConfigurableConnectionTestTrait
{
    protected function getConnection()
    {
        $this->config = self::$container->get('model-config');

        return parent::getConnection();
    }
}