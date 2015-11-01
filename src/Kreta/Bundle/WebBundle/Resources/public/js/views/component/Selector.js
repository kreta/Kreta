/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import '../../../scss/components/_selector.scss';

import React from 'react';
import classnames from 'classnames';
import $ from 'jquery';

import NavigableCollection from '../../mixins/NavigableCollection.js';

export default React.createClass({
  propTypes: {
    disabled: React.PropTypes.bool,
    label: React.PropTypes.string,
    name: React.PropTypes.string.isRequired,
    onChange: React.PropTypes.func,
    placeholder: React.PropTypes.node,
    tabIndex: React.PropTypes.number,
    value: React.PropTypes.string.isRequired
  },
  mixins: [NavigableCollection],
  componentWillMount() {
    this.setState({
      selectedValue: this.props.value,
      filter: ''
    });
  },
  componentWillReceiveProps(nextProps) {
    this.setState({
      selectedValue: nextProps.value,
      filter: ''
    });
  },
  getElementByValue(value) {
    let found = this.props.placeholder || this.props.placeholder || 'Select...';
    this.props.children.forEach((child) => {
      if (child.props.value === value) {
        found = child;
      }
    });
    return found;
  },
  openDropdown() {
    if (this.props.disabled) {
      return;
    }
    this.setState({
      dropdownVisible: true,
      filter: ''
    });

    this.refs.filter.value = '';

    setTimeout(() => { // Wait render to focus
      this.refs.filter.focus();
    }, 200);
  },
  closeDropdown() {
    this.setState({
      dropdownVisible: false
    });
  },
  selectOption(index) {
    this.setState({
      selectedValue: this.filteredValues[index]
    });
    this.closeDropdown();
    this.goToNextTabIndex();
    if (this.props.onChange) {
      this.props.onChange(this.filteredValues[index], this.props.name);
    }
  },
  highlightItem(index) {
    this.setState({
      selectedItem: index
    });
  },
  keyboardSelected(ev) {
    if (ev.which === 13 || ev.which === 9) { // Enter or tab
      // Prevent submiting form
      ev.stopPropagation();
      ev.preventDefault();
      this.selectOption(this.state.selectedItem);
    }
  },
  filter() {
    this.setState({
      filter: this.refs.filter.value,
      selectedItem: 0
    });
  },
  goToNextTabIndex() {
    $(`[tabindex="${parseInt(this.props.tabIndex, 10) + 1}"]`).focus();
  },
  getFilteredOptions() {
    // Keeps filtered values in memory to select correct item
    this.filteredValues = [];

    return this.props.children.filter((child) => {
      return !(this.state.filter !== '' && child.props.text &&
      child.props.text.toLowerCase().indexOf(this.state.filter.toLowerCase()) === -1);
    }).map((child, index) => {
      this.filteredValues.push(child.props.value);
      return React.cloneElement(child, {
        selected: this.state.selectedItem === index,
        fieldSelected: this.selectOption.bind(this, index),
        fieldHovered: this.highlightItem.bind(this, index),
        key: index
      });
    });
  },
  render() {
    const dropdownClasses = classnames(
        'selector__dropdown',
        {'selector__dropdown--open': this.state.dropdownVisible}
      ),
      selectedElement = this.getElementByValue(this.state.selectedValue);

    return (
      <div className="selector"
           onBlur={this.closeDropdown}
           onFocus={this.openDropdown}
           tabIndex={this.props.tabIndex}>
        <input name={this.props.name}
               ref="value"
               type="hidden"
               value={this.state.selectedValue}/>

        <div className="selector__selected" onMouseUp={this.openDropdown}>
          {selectedElement}
        </div>

        <div className={dropdownClasses}>
          <input className="selector__filter"
                 onChange={this.filter}
                 onKeyDown={this.keyboardSelected}
                 ref="filter"
                 type="text"/>

          <div className="selector__options" ref="navigableList">
            {this.getFilteredOptions()}
          </div>
        </div>
      </div>
    );
  }
});
