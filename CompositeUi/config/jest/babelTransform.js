/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import babelJest from 'babel-jest';

export default babelJest.createTransformer({
  presets: [require.resolve('babel-preset-react-app')],
  babelrc: false,
});
