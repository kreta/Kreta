/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import CrossIcon from './../../svg/cross.svg';

import classnames from 'classnames';
import React from 'react';

import Icon from './../component/Icon';

class ContentRightLayout extends React.Component {
  static propTypes = {
    isOpen: React.PropTypes.bool.isRequired,
    onRequestClose: React.PropTypes.func,
  };

  triggerOnRequestClose() {
    const {onRequestClose} = this.props;

    onRequestClose();
  }

  render() {
    const {isOpen, children} = this.props,
      classes = classnames({
        content__right: true,
        'content__right--visible': isOpen,
      });

    return (
      <div className={classes}>
        <div className="content-right-layout__cross">
          <Icon
            glyph={CrossIcon}
            onClick={this.triggerOnRequestClose.bind(this)}
          />
        </div>
        <div className="content__right-content">
          {children}
        </div>
      </div>
    );
  }
}

export default ContentRightLayout;
