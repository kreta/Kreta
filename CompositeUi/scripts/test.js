/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

'use strict';

process.env.NODE_ENV = 'test';
process.env.PUBLIC_URL = '';

import dotenv from 'dotenv';
dotenv.config({silent: true});

import jest from 'jest';

const argv = process.argv.slice(2);
if (!process.env.CI && argv.indexOf('--coverage') < 0) {
  argv.push('--watch');
}

jest.run(argv);
