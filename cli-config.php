<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 21/11/18
 * Time: 04:14 PM
 */

// require application bootstrap file
require_once __DIR__ . '/bootstrap.php';

// instance entity-manager
$entityManager = $container->get('entity-manager');

// return helper-set
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
