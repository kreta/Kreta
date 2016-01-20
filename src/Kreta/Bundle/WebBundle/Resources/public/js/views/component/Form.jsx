/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import $ from 'jquery';
import React from 'react';

import NotificationService from './../../service/Notification';
import FormSerializerService from './../../service/FormSerializer';

class Form extends React.Component {
  static propTypes = {
    model: React.PropTypes.func.isRequired,
    onSaveError: React.PropTypes.func,
    onSaveSuccess: React.PropTypes.func,
    onSubmit: React.PropTypes.func,
    saveErrorMessage: React.PropTypes.string,
    saveSuccessMessage: React.PropTypes.string
  };

  state = {
    errors: [],
    lastValues: []
  };

  save(ev) {
    ev.preventDefault();

    const serializedModel = FormSerializerService.serialize(
      $(this.refs.form), this.props.model
    );

    this.setState({lastValues: serializedModel.toJSON()});

    serializedModel.save(null, {
      success: (model) => {
        NotificationService.showNotification({
          type: 'success',
          message: this.props.saveSuccessMessage || 'Successfully saved'
        });
        if (this.props.onSaveSuccess) {
          this.props.onSaveSuccess(model);
        }
      }, error: (model, errors) => {
        NotificationService.showNotification({
          type: 'error',
          message: this.props.saveErrorMessage || 'Errors found'
        });
        this.setState({errors: JSON.parse(errors.responseText)});
        if (this.props.onSaveError) {
          this.props.onSaveError(model, JSON.parse(errors.responseText));
        }
      }
    });
  }

  renderFormElements () {
    return this.props.children.map((child, index) => {
      if (child.type.name === 'FormInput' && child.props.name in this.state.errors) {
        return React.cloneElement(child, {
          error: true,
          key: index,
          label: `${child.props.label}: ${this.state.errors[child.props.name][0]}`,
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
    const onSubmit = typeof this.props.onSubmit !== "undefined" ? this.props.onSubmit : this.save.bind(this);
    return (
      <form method="POST"
            ref="form"
            onSubmit={onSubmit}
        {...this.props}>
        {this.renderFormElements()}
      </form>
    );
  }
}

export default Form;
