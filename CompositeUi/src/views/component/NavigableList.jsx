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
    disabled: React.PropTypes.bool,
    xSelected: React.PropTypes.number,
    ySelected: React.PropTypes.number,
    onElementMouseEnter: React.PropTypes.func,
    onElementSelected: React.PropTypes.func,
    onXChanged: React.PropTypes.func,
    onYChanged: React.PropTypes.func,
    xLength: React.PropTypes.number,
    yLength: React.PropTypes.number
  };

  static defaultProps = {
    disabled: false,
    xLength: 0,
    yLength: 0,
    xSelected: 0,
    ySelected: 0
  };


  handleNavigation(ev) {
    if (ev.which === 40) { // Down
      this.selectNextY();
    } else if (ev.which === 38) { // Up
      this.selectPrevY();
    } else if (ev.which === 37) { // Left
      this.selectPrevX();
    } else if (ev.which === 39) { // Right
      this.selectNextX();
    }
  }

  selectNextX() {
    const {xSelected, xLength} = this.props;
    if (xSelected + 1 < xLength) {
      if (this.props.onXChanged) {
        this.props.onXChanged(xSelected + 1);
      }
    }
  }

  selectPrevX() {
    const {xSelected} = this.props;
    if (xSelected > 0) {
      if (this.props.onXChanged) {
        this.props.onXChanged(xSelected - 1);
      }
    }
  }

  selectY(index) {
    const {yLength, onYChanged} = this.props;

    if (index >= 0 && index < yLength) {
      if (onYChanged) {
        onYChanged(index);
      }
      this.centerListScroll();
    }
  }

  selectNextY() {
    const {ySelected, yLength} = this.props;
    if (ySelected + 1 < yLength) {
      if (this.props.onYChanged) {
        this.props.onYChanged(ySelected + 1);
      }
      this.centerListScroll();
    }
  }

  selectPrevY() {
    const {ySelected} = this.props;
    if (ySelected > 0) {
      if (this.props.onYChanged) {
        this.props.onYChanged(ySelected - 1);
      }
      this.centerListScroll();
    }
  }

  centerListScroll() {
    ReactDOM.findDOMNode(this).scrollTop = this.props.ySelected * 60 - 60 * 2;
  }

  render() {
    const {
      onXChanged,
      onYChanged,
      onElementSelected,
      xLength,
      yLength,
      children,
      classNameSelected,
      xSelected,
      ySelected,
      ...otherProps
    } = this.props;
    
    const wrappedItems = children.map((el, i) => (
      <div key={i}
           onMouseEnter={this.selectY.bind(this, i)}
           onClick={onElementSelected}
           className={ i === ySelected ? classNameSelected : ''}>
        {el}
      </div>
    ));
    
    return <div {...otherProps}>{wrappedItems}</div>;
  }
}

export default NavigableList;
