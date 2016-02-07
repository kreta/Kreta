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
import ReactDOM from 'react-dom';

class NavigableList extends React.Component {
  static propTypes = {
    onXChanged: React.PropTypes.func,
    onYChanged: React.PropTypes.func,
    xLength: React.PropTypes.number,
    yLength: React.PropTypes.number
  };

  static defaultProps = {
    disabled: false,
    xLength: 0,
    yLength: 0
  };

  xSelected = 0;
  ySelected = 0;

  componentDidMount() {
    this.keyUpListenerRef = this.handleNavigation.bind(this);
    window.addEventListener('keyup', this.keyUpListenerRef);
  }

  componentWillUnmount() {
    window.removeEventListener('keyup', this.keyUpListenerRef);
  }

  handleNavigation(ev) {
    if (ev.which === 40) { // Down
      this.selectNextY();
      ev.preventDefault();
      ev.stopPropagation();
    } else if (ev.which === 38) { // Up
      this.selectPrevY();
      ev.preventDefault();
      ev.stopPropagation();
    } else if (ev.which === 37) { // Left
      this.selectPrevX();
      ev.preventDefault();
      ev.stopPropagation();
    } else if (ev.which === 39) { // Right
      this.selectNextX();
      ev.preventDefault();
      ev.stopPropagation();
    }
  }

  selectNextX() {
    if (this.xSelected + 1 < this.props.xLength) {
      this.xSelected = this.xSelected + 1;
      if (this.props.onXChanged) {
        this.props.onXChanged(this.xSelected);
      }
    }
  }

  selectPrevX() {
    if (this.xSelected > 0) {
      this.xSelected = this.xSelected - 1;
      if (this.props.onXChanged) {
        this.props.onXChanged(this.xSelected);
      }
    }
  }

  selectNextY() {
    if (this.ySelected + 1 < this.props.yLength) {
      this.ySelected = this.ySelected + 1;
      if (this.props.onYChanged) {
        this.props.onYChanged(this.ySelected);
      }
      this.centerListScroll();
    }
  }

  selectPrevY() {
    if (this.ySelected > 0) {
      this.ySelected = this.ySelected - 1;
      if (this.props.onYChanged) {
        this.props.onYChanged(this.ySelected);
      }
      this.centerListScroll();
    }
  }

  centerListScroll() {
    ReactDOM.findDOMNode(this).scrollTop = this.ySelected * 60 - 60 * 2;
  }

  render() {
    return <div {...this.props}>{this.props.children}</div>;
  }
}

export default NavigableList;
