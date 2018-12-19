<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/11/18
 * Time: 09:13 AM
 */

require_once __DIR__ . '/../bootstrap.php';

$router = $container->get('router');

/** @var \Psr\Http\Message\ServerRequestInterface $request */
$request = $container->get('request');

$response = $router->dispatch($request);

$container->get('emitter')->emit($response);

exit();
