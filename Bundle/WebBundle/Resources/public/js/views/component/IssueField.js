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
    halfColumn: React.PropTypes.bool,
    image: React.PropTypes.node,
    label: React.PropTypes.string,
    value: React.PropTypes.string.isRequired
  },
  render() {
    const classes = classnames(
      'issue-field', {'issue-field--half': this.props.halfColumn}
    );
    return (
      <div className={classes}>
        <div className="issue-field__image">
          {this.props.image}
        </div>
        <span className="issue-field__label">{this.props.label}</span>
        <span className="issue-field__value">{this.props.value}</span>
      </div>
    );
  }
});
