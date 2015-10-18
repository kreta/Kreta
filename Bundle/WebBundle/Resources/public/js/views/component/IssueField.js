/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../scss/components/_issue-field.scss';

import React from 'react';
import classnames from 'classnames';

export default React.createClass({
  propTypes: {
    fieldHovered: React.PropTypes.func,
    fieldSelected: React.PropTypes.func,
    halfColumn: React.PropTypes.bool,
    image: React.PropTypes.node,
    label: React.PropTypes.string,
    selected: React.PropTypes.bool,
    text: React.PropTypes.string,
    value: React.PropTypes.string.isRequired
  },
  fieldSelected() {
    if(this.props.fieldSelected) {
      this.props.fieldSelected();
    }
  },
  render() {
    const classes = classnames(
      'issue-field', {
        'issue-field--half': this.props.halfColumn,
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
});
