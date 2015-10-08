/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../scss/components/_modal.scss';

import React from 'react';
import classNames from 'classnames';

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
      <div>
        <div className={ modalClasses }>
          { this.props.children }
        </div>
        <div className={ overlayClasses }
             onClick={this.closeModal}/>
      </div>
    );
  }
});
