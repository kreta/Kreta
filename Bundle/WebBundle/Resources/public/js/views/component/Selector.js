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
    label: React.PropTypes.string,
    name: React.PropTypes.string.isRequired,
    onChange: React.PropTypes.func,
    placeholder: React.PropTypes.string,
    tabIndex: React.PropTypes.number,
    value: React.PropTypes.string.isRequired
  },
  mixins: [NavigableCollection],
  componentWillMount() {
    this.setState({
      selectedValue: this.props.value
    });
  },
  getElementByValue(value) {
    let found = '';
    this.props.children.forEach((child) => {
      if (child.props.value === value) {
        found = child;
      }
    });
    return found;
  },
  openDropdown() {
    this.setState({
      dropdownVisible: true
    });
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
      selectedValue: this.props.children[index].props.value,
      dropdownVisible: false
    });
    this.goToNextTabIndex();
    if (this.props.onChange) {
      this.props.onChange(this.state.selectedValue);
    }
  },
  highlightItem(index) {
    this.setState({
      selectedItem: index
    });
  },
  filter(ev) {
    if (ev.which === 13 || ev.which === 9) { // Enter or tab
      ev.stopPropagation();
      ev.preventDefault();
      this.selectOption(this.state.selectedItem);
    }
  },
  goToNextTabIndex() {
    $(`[tabindex="${parseInt(this.props.tabIndex, 10) + 1}"]`).focus();
  },
  render() {
    const dropdownClasses = classnames(
      'selector__dropdown',
      {'selector__dropdown--open': this.state.dropdownVisible}
    ),
    selectedElement = this.getElementByValue(this.state.selectedValue),
    children = this.props.children.map((child, index) => {
      return React.cloneElement(child, {
        selected: this.state.selectedItem === index,
        fieldSelected: this.selectOption.bind(this, index),
        fieldHovered: this.highlightItem.bind(this, index),
        key: index
      });
    });

    return (
      <div className="selector"
           onBlur={this.closeDropdown}
           onFocus={this.openDropdown}
           tabIndex={this.props.tabIndex}>
        <input name={this.props.name}
               ref="value"
               type="hidden"
               value={this.state.selectedValue}/>
        <div className="selector__selected" onClick={this.openDropdown}>
          {selectedElement}
        </div>

        <div className={dropdownClasses}>
          <input className="selector__filter"
                 onKeyDown={this.filter}
                 ref="filter"
                 type="text"/>

          <div className="selector__options" ref="navigableList">
            {children}
          </div>
        </div>
      </div>
    );
  }
});
