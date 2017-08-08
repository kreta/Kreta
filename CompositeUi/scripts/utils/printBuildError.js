/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import get from 'lodash/get';
import chalk from 'chalk';

export default (error) => {
  const message = get(error, 'message');
  const stack = get(error, 'stack');

  if (
    stack &&
    typeof message === 'string' &&
    message.indexOf('from UglifyJs') !== -1
  ) {
    try {
      const matched = /Unexpected token:(.+)\[(.+)\:(.+)\,(.+)\]\[.+\]/.exec(
        stack
      );
      if (!matched) {
        throw new Error(
          "The regex pattern is not matched. Maybe UglifyJs changed it's message?"
        );
      }
      const problemPath = matched[2];
      const line = matched[3];
      const column = matched[4];
      console.log(
        'Failed to minify the code from this file: \n\n',
        chalk.yellow(`${problemPath} line ${line}:${column}`),
        '\n'
      );
    } catch (ignored) {
      console.log('Failed to minify the code.', error);
    }
    console.log('Read more here: http://bit.ly/2tRViJ9');
  } else {
    console.log((message || error) + '\n');
  }
  console.log();
};
