/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_selector';

import $ from 'jquery';
import classnames from 'classnames';
import React from 'react';

import NavigableList from './../component/NavigableList';

class Selector extends React.Component {
  static propTypes = {
    disabled: React.PropTypes.bool,
    label: React.PropTypes.string,
    name: React.PropTypes.string.isRequired,
    onChange: React.PropTypes.func,
    placeholder: React.PropTypes.node,
    tabIndex: React.PropTypes.number,
    value: React.PropTypes.string.isRequired
  };

  componentWillMount() {
    this.setState({
      selectedRow: 0,
      selectedValue: this.props.value,
      filter: ''
    });
  }

  componentWillReceiveProps(nextProps) {
    this.setState({
      selectedValue: nextProps.value,
      filter: ''
    });
  }

  getElementByValue(value) {
    let found = this.props.placeholder || this.props.placeholder || 'Select...';
    this.props.children.forEach((child) => {
      if (child.props.value === value) {
        found = child;
      }
    });
    return found;
  }

  selectOption(index) {
    this.setState({
      selectedValue: this.filteredValues[index]
    });
    if (this.props.onChange) {
      this.props.onChange(this.filteredValues[index], this.props.name);
    }
  }

  highlightItem(index) {
    this.setState({selectedRow: index});
  }

  keyboardSelected(ev) {
    if (ev.which === 13 || ev.which === 9) { // Enter or tab
      if (ev.which === 13) {
        // Prevent submiting form
        ev.stopPropagation();
        ev.preventDefault();
        $(`[tabindex="${parseInt(this.props.tabIndex, 10) + 1}"]`).focus();
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

    return this.props.children.filter((child) => {
      return !(this.state.filter !== '' && child.props.text &&
      child.props.text.toLowerCase().indexOf(this.state.filter.toLowerCase()) === -1);
    }).map((child, index) => {
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
    const selectedElement = this.getElementByValue(this.state.selectedValue),
      classes = classnames('selector', {
        'selector--disabled': this.props.disabled
      }),
      filteredOptions = this.getFilteredOptions();
    return (
      <div className={classes}>
        <input name={this.props.name}
               ref="value"
               type="hidden"
               value={this.state.selectedValue}/>
        <input className="selector__filter"
               onChange={this.filter.bind(this)}
               onKeyDown={this.keyboardSelected.bind(this)}
               ref="filter"
               tabIndex={this.props.tabIndex}
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
