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

declare(strict_types=1);

use Kreta\IdentityAccess\Infrastructure\Symfony\Framework\AppKernel;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../.././../../../../../../vendor/autoload.php';

$kernel = new AppKernel('prod', false);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
