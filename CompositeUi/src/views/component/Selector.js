/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../scss/components/_selector';

import classnames from 'classnames';
import React from 'react';

import NavigableList from './../component/NavigableList';

class Selector extends React.Component {
  static propTypes = {
    children: React.PropTypes.arrayOf(React.PropTypes.element),
    disabled: React.PropTypes.bool,
    label: React.PropTypes.string,
    name: React.PropTypes.string.isRequired,
    tabIndex: React.PropTypes.number
  };

  componentWillMount() {
    this.setState({
      selectedRow: 0,
      filter: ''
    });
  }

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

  selectOption(index) {
    this.props.input.onChange(this.filteredValues[index]);
  }

  highlightItem(index) {
    this.setState({selectedRow: index});
  }

  keyboardSelected(ev) {
    if (ev.which === 13 || ev.which === 9) { // Enter or tab
      if (ev.which === 13) {
        // Prevent submitting form
        ev.stopPropagation();
        ev.preventDefault();
        document.querySelector(`[tabindex="${parseInt(this.props.tabIndex, 10) + 1}"]`).focus();
      }
      this.selectOption(this.state.selectedRow);
    } else {
      this.refs.navigableList.handleNavigation(ev);
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
        selected: this.state.selectedRow === index,
        fieldSelected: this.selectOption.bind(this, index),
        fieldHovered: this.highlightItem.bind(this, index),
        key: index
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

        <input className="selector__filter"
               onChange={this.filter.bind(this)}
               onKeyDown={this.keyboardSelected.bind(this)}
               ref="filter"
               tabIndex={tabIndex}
               type="text"/>

        <div className="selector__selected">
          {selectedElement}
        </div>

        <NavigableList className="selector__options"
                       onYChanged={this.highlightItem.bind(this)}
                       ref="navigableList"
                       yLength={filteredOptions.length}>
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
