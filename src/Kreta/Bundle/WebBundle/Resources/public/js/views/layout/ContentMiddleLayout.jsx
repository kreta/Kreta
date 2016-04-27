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
import classNames from 'classnames';

class ContentMiddleLayout extends React.Component {
  static propTypes = {
    centered: React.PropTypes.bool
  };

  static defaultProps = {
    centered: false
  };

  render() {
    const contentClasses =  classNames(
      'content__middle-content', {
      'content__middle-content--centered': this.props.centered
    });

    return (
      <div className="content__middle">
        <div className={contentClasses}>
          {this.props.children}
        </div>
      </div>
    );
  }
}

export default ContentMiddleLayout;
