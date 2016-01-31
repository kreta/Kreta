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

class Form extends React.Component {
  static propTypes = {
    onSaveError: React.PropTypes.func,
    onSaveSuccess: React.PropTypes.func,
    onSubmit: React.PropTypes.func,
    saveErrorMessage: React.PropTypes.string,
    saveSuccessMessage: React.PropTypes.string
  };

  renderFormElements () {
    return this.props.children.map((child, index) => {
      if (child.type.name === 'FormInput' && child.props.name in this.props.errors) {
        return React.cloneElement(child, {
          error: true,
          key: index,
          label: `${child.props.label}: ${this.props.errors[child.props.name][0]}`,
          value: child.props.name in this.state.lastValues ?
            this.state.lastValues[child.props.name] : child.props.value
        });
      } else if (child.type.name === 'FormInput') {
        return React.cloneElement(child, {
          value: child.props.name in this.state.lastValues ?
            this.state.lastValues[child.props.name] : child.props.value
        });
      }
      return child;
    });
  }

  render() {
    return (
      <form method="POST"
            onSubmit={this.props.onSubmit}
            ref="form"
        {...this.props}>
        {this.props.children}
      </form>
    );
  }
}

export default Form;
