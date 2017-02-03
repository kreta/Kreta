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

use Kreta\TaskManager\Infrastructure\Symfony\Framework\AppKernel;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../.././../../../../../../vendor/autoload.php';

if (PHP_VERSION_ID < 70000) {
    include_once __DIR__ . '/../../../../../../../../var/bootstrap.php.cache';
}

$kernel = new AppKernel('prod', false);
if (PHP_VERSION_ID < 70000) {
    $kernel->loadClassCache();
}

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
