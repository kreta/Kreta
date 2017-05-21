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

use Kreta\PhpCsFixerConfig\KretaConfig;

$config = new KretaConfig();
$config->getFinder()->in([
    __DIR__ . '/../../src',
]);

$cacheDir = getenv('TRAVIS') ? getenv('HOME') . '/.php-cs-fixer' : __DIR__ . '/../..';

$config->setCacheFile($cacheDir . '/.php_cs.cache');

return $config;
