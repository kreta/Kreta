<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

date_default_timezone_set('Europe/Madrid');

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__ . '/../app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__ . '/../app/AppKernel.php';

if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '192.168.10.1', '::1'])
) {
    header('HTTP/1.0 403 Forbidden');
    exit(
        'You are not allowed to access this file from '
        . @$_SERVER['REMOTE_ADDR']
        . '. Check '
        . basename(__FILE__) . ' for more information.'
    );
}

$kernel = new AppKernel('test', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
