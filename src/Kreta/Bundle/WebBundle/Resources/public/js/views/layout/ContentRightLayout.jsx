/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import classnames from 'classnames';
import React from 'react';

class ContentRightLayout extends React.Component {
  static propTypes = {
    open: React.PropTypes.bool
  };

  render() {
    const classes = classnames({
      'content__right': true,
      'content__right--visible': this.props.open
    });

    return (
      <div className={classes}>
        <div className="content__right-content">
          {this.props.children}
        </div>
      </div>
    );
  }
}

export default ContentRightLayout;
