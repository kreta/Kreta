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
  state = {
    visible: false
  };

  openContentRightLayout() {
    this.setState({visible: true});
  }

  closeContentRightLayout() {
    this.setState({visible: false});
  }

  render() {
    const classes = classnames({
      'content__right': true,
      'content__right--visible': this.state.visible
    });

    return (
      <div className={classes}>
        <Icon className="content-right-layout__cross"
              glyph={CrossIcon}
              onClick={this.closeContentRightLayout.bind(this)}/>
        <div className="content__right-content">
          {this.props.children}
        </div>
      </div>
    );
  }
}

export default ContentRightLayout;
