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

import NavigableCollection from './../../mixins/NavigableCollection';

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
  selectOption(index) {
    this.setState({
      selectedValue: this.filteredValues[index]
    });
    if (this.props.onChange) {
      this.props.onChange(this.filteredValues[index], this.props.name);
    }
  },
  highlightItem(index) {
    this.setState({selectedItem: index});
  },
  keyboardSelected(ev) {
    if (ev.which === 13 || ev.which === 9) { // Enter or tab
      if (ev.which === 13) {
        // Prevent submiting form
        ev.stopPropagation();
        ev.preventDefault();
        $(`[tabindex="${parseInt(this.props.tabIndex, 10) + 1}"]`).focus();
      }
      this.selectOption(this.state.selectedItem);
    }
  },
  filter() {
    this.setState({
      filter: this.refs.filter.value,
      selectedItem: 0
    });
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
    const selectedElement = this.getElementByValue(this.state.selectedValue),
      classes = classnames('selector', {
        'selector--disabled': this.props.disabled
      });
    return (
      <div className={classes}>
        <input name={this.props.name}
               ref="value"
               type="hidden"
               value={this.state.selectedValue}/>
        <input className="selector__filter"
               onChange={this.filter}
               onKeyDown={this.keyboardSelected}
               ref="filter"
               tabIndex={this.props.tabIndex}
               type="text"/>
        <div className="selector__selected">
          {selectedElement}
        </div>
        <div className="selector__options" ref="navigableList">
            {this.getFilteredOptions()}
        </div>
      </div>
    );
  },
  focus() {
    this.refs.filter.value = '';
    this.refs.filter.focus();
  }
});
