/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import CrossIcon from './../../../svg/cross';

import classnames from 'classnames';
import React from 'react';

import Icon from './../component/Icon';

class ContentRightLayout extends React.Component {
  static propTypes = {
    isOpen: React.PropTypes.bool.isRequired,
    onRequestClose: React.PropTypes.func
  };

  triggerOnRequestClose() {
    this.props.onRequestClose();
  }

  render() {
    const classes = classnames({
      'content__right': true,
      'content__right--visible': this.props.isOpen
    });

    return (
      <div className={classes}>
        <Icon className="content-right-layout__cross"
              glyph={CrossIcon}
              onClick={this.triggerOnRequestClose.bind(this)}/>
        <div className="content__right-content">
          {this.props.children}
        </div>
      </div>
    );
  }
}

export default ContentRightLayout;
