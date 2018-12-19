<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 21/11/18
 * Time: 04:16 PM
 */

define("BASE_DIR", \realpath(__DIR__));

require_once BASE_DIR . "/vendor/autoload.php";

$container = \App\Core\AppContainer::make(BASE_DIR);
