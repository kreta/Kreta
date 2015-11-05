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

class Icon extends React.Component {
  static propTypes = {
    glyph: React.PropTypes.string.isRequired
  };

  render() {
    const {glyph, ...props} = this.props;

    return (
      <svg {...props}>
        <use xlinkHref={glyph}/>
      </svg>
    );
  }
}

export default Icon;
