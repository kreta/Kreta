/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
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
    options: React.PropTypes.array.isRequired,
    placeholder: React.PropTypes.string,
    tabIndex: React.PropTypes.number,
    value: React.PropTypes.string
  },
  mixins: [NavigableCollection],
  componentWillMount() {
    this.setState({
      selectedValue: this.props.value
    });
  },
  getLabelByValue(value) {
    let found = null;
    this.props.options.forEach((option) => {
      if (option.value === value) {
        found = option.label;
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
    })
  },
  selectOption(index) {
    this.setState({
      selectedValue: this.props.options[index].value,
      dropdownVisible: false
    });
    this.goToNextTabIndex();
    if(this.props.onChange) {
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
     $(`[tabindex="${parseInt(this.props.tabIndex) + 1}"]`).focus();
  },
  render() {
    const options = this.props.options.map((option, index) => {
      const classes = classnames(
        'selector__option',
        {'selector__option--selected': this.state.selectedItem === index}
      );
      return (
        <div className={classes}
             onClick={this.selectOption.bind(this, index)}
             onMouseEnter={this.highlightItem.bind(this, index)}>
          {option.label}
        </div>
      );
    });
    const dropdownClasses = classnames(
      'selector__dropdown',
      {'selector__dropdown--open': this.state.dropdownVisible}
    );
    return (
      <div className="selector"
           onFocus={this.openDropdown}
           onBlur={this.closeDropdown}
           tabIndex={this.props.tabIndex}>
        <input value={this.state.selectedValue}
               name={this.props.name}
               ref="value"
               type="hidden"/>
        <span className="selector__selected" onClick={this.openDropdown}>
          {this.getLabelByValue(this.state.selectedValue) ||
            this.props.placeholder || 'Select...'}
        </span>

        <div className={dropdownClasses}>
          <input className="selector__filter"
                 onKeyDown={this.filter}
                 ref="filter"
                 type="text"/>
          <div className="selector__options" ref="navigableList">
            {options}
          </div>
        </div>
      </div>
    );
  }
});
