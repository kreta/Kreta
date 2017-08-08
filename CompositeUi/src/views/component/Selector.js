/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_selector.scss';

import classnames from 'classnames';
import React from 'react';

import NavigableList from './../component/NavigableList';

class Selector extends React.Component {
  static propTypes = {
    children: React.PropTypes.arrayOf(React.PropTypes.element),
    disabled: React.PropTypes.bool,
    label: React.PropTypes.string,
    name: React.PropTypes.string,
    tabIndex: React.PropTypes.number
  };

  state = {
    filter: ''
  };

  componentWillReceiveProps() {
    this.setState({
      filter: ''
    });
  }

  getElementByValue(value) {
    let found = this.props.children[0];
    this.props.children.forEach((child) => {
      if (child.props.value === value) {
        found = child;
      }
    });
    return found;
  }

  selectOption(x, y) {
    this.props.input.onChange(this.filteredValues[y]);
  }

  keyboardSelected(ev) {
    this.refs.navigableList.handleNavigation(ev);

    if (ev.which === 13) {
      document.querySelector(`[tabindex="${parseInt(this.props.tabIndex, 10) + 1}"]`).focus();
    }
  }

  filter() {
    this.setState({
      filter: this.refs.filter.value,
      selectedRow: 0
    });
  }

  getFilteredOptions() {
    // Keeps filtered values in memory to select correct item
    this.filteredValues = [];

    return this.props.children.filter((child) => (
      child.props.value !== '' && (
        this.state.filter === '' ||
        child.props.text.toLowerCase().indexOf(
          this.state.filter.toLowerCase()) !== -1
      )
    )).map((child, index) => {
      this.filteredValues.push(child.props.value);

      return React.cloneElement(child, {
        key: index,
        onMouseDown: this.selectOption.bind(this, 0, index)
      });
    });
  }

  render() {
    const
      {input, tabIndex} = this.props,
      selectedElement = this.getElementByValue(input.value),
      classes = classnames('selector', {
        'selector--disabled': input.disabled
      }),
      filteredOptions = this.getFilteredOptions();

    return (
      <div className={classes}>
        <input {...input} type="hidden"/>

        <input
          className="selector__filter"
          onChange={this.filter.bind(this)}
          onKeyDown={this.keyboardSelected.bind(this)}
          ref="filter"
          tabIndex={tabIndex}
          type="text"
        />

        <div className="selector__selected">
          {selectedElement}
        </div>

        <NavigableList
          className="selector__options"
          onElementSelected={this.selectOption.bind(this)}
          ref="navigableList"
        >
          {filteredOptions}
        </NavigableList>
      </div>
    );
  }

  focus() {
    this.refs.filter.value = '';
    this.refs.filter.focus();
  }
}

export default Selector;
