/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_modal.scss';

import classNames from 'classnames';
import React from 'react';

class Modal extends React.Component {
  static propTypes = {
    isOpen: React.PropTypes.bool.isRequired,
    onRequestClose: React.PropTypes.func
  };

  closeModal() {
    this.props.onRequestClose();
  }

  render() {
    const modalClasses = classNames({
        'modal': true,
        'modal--visible': this.props.isOpen
      }),
      overlayClasses = classNames({
        'modal__overlay': true,
        'modal__overlay--visible': this.props.isOpen
      });

    return (
      <div>
        <div className={modalClasses}>
          {this.props.children}
        </div>
        <div className={overlayClasses} onClick={this.closeModal.bind(this)}/>
      </div>
    );
  }
}

export default Modal;
