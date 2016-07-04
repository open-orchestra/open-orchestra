<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__.'/../app/autoload.php';

$apcLoader = new ApcClassLoader('open_orchestra', $loader);
$loader->unregister();
$apcLoader->register(true);

$kernel = new AppKernel('load_test', false);
$kernel->loadClassCache();

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
