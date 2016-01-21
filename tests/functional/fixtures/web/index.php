<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

date_default_timezone_set('Europe/Madrid');

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

$loader = require __DIR__ . '/../app/autoload.php';
Debug::enable();

$kernel = new AppKernel('test', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
