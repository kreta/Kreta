/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../../../scss/components/_issue-field';

import classnames from 'classnames';
import React from 'react';

class IssueField extends React.Component {
  static propTypes = {
    fieldHovered: React.PropTypes.func,
    fieldSelected: React.PropTypes.func,
    halfColumn: React.PropTypes.bool,
    alignLeft: React.PropTypes.bool,
    image: React.PropTypes.node,
    label: React.PropTypes.string,
    selected: React.PropTypes.bool,
    text: React.PropTypes.string,
    value: React.PropTypes.string.isRequired
  };

  render() {
    const classes = classnames(
      'issue-field', {
        'issue-field--half': this.props.halfColumn,
        'issue-field--left': this.props.alignLeft,
        'issue-field--selected': this.props.selected
      }
    );

    return (
      <div className={classes}
           onMouseDown={this.props.fieldSelected}
           onMouseEnter={this.props.fieldHovered}>
        <div className="issue-field__image">
          {this.props.image}
        </div>
        <span className="issue-field__label">{this.props.label}</span>
        <span className="issue-field__value">{this.props.text}</span>
      </div>
    );
  }
}

export default IssueField;
