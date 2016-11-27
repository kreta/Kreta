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
import classnames from 'classnames';

import './../../scss/components/_selector-option';

class SelectorOption extends React.Component {
  static propTypes = {
    alignLeft: React.PropTypes.bool,
    fieldHovered: React.PropTypes.func,
    fieldSelected: React.PropTypes.func,
    label: React.PropTypes.string,
    selected: React.PropTypes.bool,
    text: React.PropTypes.string.isRequired,
    thumbnail: React.PropTypes.element,
    value: React.PropTypes.string.isRequired
  };

  render() {
    const classes = classnames(
      'selector-option', {
        'selector-option--left': this.props.alignLeft,
        'selector-option--selected': this.props.selected
      }
    );

    let thumbnail = '';
    if (this.props.thumbnail) {
      thumbnail = (
        <div className="selector-option__thumbnail">
          {this.props.thumbnail}
        </div>
      );
    }

    return (
      <div className={classes}
           onMouseDown={this.props.fieldSelected}
           onMouseEnter={this.props.fieldHovered}>
        {thumbnail}
        <span className="selector-option__label">{this.props.label}</span>
        <span className="selector-option__value">{this.props.text}</span>
      </div>
    );
  }
}

export default SelectorOption;
