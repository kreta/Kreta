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
import $ from 'jquery';

import {NotificationService} from '../../service/Notification.js';
import {FormSerializerService} from '../../service/FormSerializer';

export default React.createClass({
  propTypes: {
    model: React.PropTypes.object.isRequired,
    onSaveSuccess: React.PropTypes.func,
    onSaveError: React.PropTypes.func,
    saveErrorMessage: React.PropTypes.string,
    saveSuccessMessage: React.PropTypes.string
  },
  save(ev) {
    ev.preventDefault();

    const model = FormSerializerService.serialize(
      $(this.refs.form), this.props.model
    );

    model.save(null, {
      success: (model) => {
        NotificationService.showNotification({
          type: 'success',
          message: this.props.saveSuccessMessage || 'Successfully saved'
        });
        if(this.props.onSaveSuccess) {
          this.props.onSaveSuccess(model);
        }
      }, error: (errors) => {
        NotificationService.showNotification({
          type: 'error',
          message:  this.props.saveErrorMessage || 'Errors found'
        });
        if(this.props.onSaveError) {
          this.props.onSaveError(errors);
        }
      }
    });
  },
  render() {
    return (
      <form onSubmit={this.save}
            method="POST"
            ref="form">
        {this.props.children}
      </form>
    );
  }
});
