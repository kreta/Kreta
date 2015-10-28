/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import '../../../../scss/views/page/project/_new.scss';

import React from 'react';
import {History} from 'react-router';
import $ from 'jquery';

import {Project} from '../../../models/Project';
import {FormSerializerService} from '../../../service/FormSerializer';
import {NotificationService} from '../../../service/Notification.js';
import ContentMiddleLayout from '../../layout/ContentMiddleLayout.js';

export default React.createClass({
  mixins: [History],
  save(ev) {
    ev.preventDefault();

    const project = FormSerializerService.serialize(
      $(this.refs.form), Project
    );

    project.save(null, {
      success: (model) => {
        NotificationService.showNotification({
          message: 'Project created successfully'
        });
        App.collection.project.add(model);
        this.history.pushState(null, `/project/${model.id}`);
      }, error: () => {
        NotificationService.showNotification({
          type: 'error',
          message: 'Error while saving this project'
        });
      }
    });
  },
  render() {
    return (
      <ContentMiddleLayout>
        <form onSubmit={this.save} ref="form">
          <input className="big"
                 name="name"
                 placeholder="Type your project name"
                 tabIndex="1"
                 type="text"/>
          <input maxLength="4"
                 name="shortName"
                 placeholder="Type a short name for your project"
                 tabIndex="2"
                 type="text"/>
          <div className="issue-new__actions">
            <button className="button green"
                    tabIndex="3"
                    type="submit">
              Done
            </button>
          </div>
        </form>
      </ContentMiddleLayout>
    );
  }
});
