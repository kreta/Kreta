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
    onElementSelected: React.PropTypes.func,
  };

  state = {
    xSelected: 0,
    ySelected: 0
  };

  handleNavigation(ev) {
    if (ev.which === 13) { // Enter
      this.goToItemLink();
    } else if (ev.which === 40) { // Down
      this.selectNextY();
    } else if (ev.which === 38) { // Up
      this.selectPrevY();
    } else if (ev.which === 37) { // Left
      this.selectPrevX();
    } else if (ev.which === 39) { // Right
      this.selectNextX();
    }
  }

  goToItemLink() {
    const {children} = this.props,
      {xSelected, ySelected} = this.state,
      link = this.findXNavigable(children[ySelected].props.children)[xSelected].props.to;

    this.props.onElementSelected(xSelected, ySelected, link);
  }

  findXNavigable(children) {
    let navigables = [];

    children.forEach((child) => {
      if (child.type.name === 'NavigableListItemLink') {
        navigables.push(child);
      } else if (Array.isArray(child.props.children)) {
        navigables = [...navigables, ...this.findXNavigable(child.props.children)];
      }
    });

    return navigables;
  }

  selectNextX() {
    const {xSelected, ySelected} = this.state,
      {children} = this.props,
      navigableItems = this.findXNavigable(children[ySelected].props.children);

    if (xSelected + 1 < navigableItems.length) {
      this.setState({xSelected: xSelected + 1});
    }
  }

  selectPrevX() {
    const {xSelected} = this.state;

    if (xSelected > 0) {
      this.setState({xSelected: xSelected - 1});
    }
  }

  selectY(index) {
    const {children} = this.props;

    if (index >= 0 && index < children.length) {
      this.setState({ySelected: index});
    }
  }

  selectNextY() {
    const {ySelected} = this.state,
      {children} = this.props;
    if (ySelected + 1 < children.length) {
      this.setState({ySelected: ySelected + 1});
    }
  }

  selectPrevY() {
    const {ySelected} = this.state;
    if (ySelected > 0) {
      this.setState({ySelected: ySelected - 1});
    }
  }

  centerListScroll() {
    ReactDOM.findDOMNode(this).scrollTop = this.state.ySelected * 60 - 60 * 2;
  }

  render() {
    const
      {children, ...otherProps} = this.props,
      {xSelected, ySelected} = this.state;

    const wrappedItems = children.map((el, i) => {
      if (i === ySelected) {
        const navigableItems = this.findXNavigable(el.props.children);
        navigableItems[xSelected] = React.cloneElement(navigableItems[xSelected], {selected: true});
      }

      return (
        <div className={ i === ySelected ? 'navigable-list__item--selected' : ''}
             key={i}
             onMouseEnter={this.selectY.bind(this, i)}>
          {el}
        </div>
      );
    });

    return <div {...otherProps}>{wrappedItems}</div>;
  }
}

export default NavigableList;
