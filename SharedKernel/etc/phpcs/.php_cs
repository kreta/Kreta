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

$fixers = include __DIR__ . '/common.php';

$finder = Symfony\CS\Finder::create()
    ->notName('*Spec.php')
    ->name('*.php')
    ->in([
        __DIR__ . '/../../src'
    ]);

return Symfony\CS\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->finder($finder)
    ->fixers($fixers);
