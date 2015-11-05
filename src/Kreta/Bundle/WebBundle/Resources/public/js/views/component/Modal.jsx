/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_modal';

import classNames from 'classnames';
import React from 'react';

export default React.createClass({
  getInitialState() {
    return {
      visible: false
    };
  },
  openModal() {
    this.setState({
      visible: true
    });
  },
  closeModal() {
    this.setState({
      visible: false
    });
  },
  handleKeyUp(ev) {
    if (ev.which === 27) {
      this.closeModal();
    }
  },
  render() {
    const modalClasses = classNames({
        'modal': true,
        'modal--visible': this.state.visible
      }),
      overlayClasses = classNames({
        'modal__overlay': true,
        'modal__overlay--visible': this.state.visible
      });

    return (
      <div onKeyUp={this.handleKeyUp}>
        <div className={ modalClasses }>
          { this.props.children }
        </div>
        <div className={ overlayClasses }
             onClick={this.closeModal}/>
      </div>
    );
  }
});
