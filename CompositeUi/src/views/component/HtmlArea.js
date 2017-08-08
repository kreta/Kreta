/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react';

const HtmlArea = props => {
  const {className, children} = props;

  return (
    <div
      className={className}
      dangerouslySetInnerHTML={{__html: children}} // eslint-disable-line react/no-danger
    />
  );
};

export default HtmlArea;
