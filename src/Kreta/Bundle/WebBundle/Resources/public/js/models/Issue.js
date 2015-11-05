/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import _ from 'lodash';
import $ from 'jquery';
import Backbone from 'backbone';

import {Config} from './../Config';

export class Issue extends Backbone.Model {
  urlRoot() {
    return `${Config.baseUrl}/issues`;
  }

  urlTransition() {
    return `${Config.baseUrl}/issues/${this.id}/transitions`;
  }

  defaults() {
    return {
      title: '',
      description: '',
      project: {
        id: '',
        name: ''
      },
      assignee: {
        id: '',
        name: '',
        photo: {
          name: ''
        }
      },
      type: {
        id: '',
        name: ''
      },
      priority: {
        id: '',
        name: ''
      }
    };
  }

  canEdit(user) {
    return this.get('assignee').id === user.id
      || this.get('reporter').id === user.id;
  }

  toJSON(options) {
    var data = _.clone(this.attributes);

    if (typeof options !== 'undefined' && options.parse) {
      data = _.omit(data, 'id');
    }

    return data;
  }

  doTransition(transitionId, options = {}) {
    var defaultOptions = {
      success: null,
      error: null
    };

    options = $.extend(defaultOptions, options);
    Backbone.$.ajax(this.urlTransition(), {
      method: 'PATCH',
      data: {
        'transition': transitionId
      },
      success: options.success,
      error: options.error
    });
  }

  getAllowedTransitions() {
    var projectHref = this.attributes._links.project.href,
      projectId = projectHref.substring(projectHref.lastIndexOf('/') + 1),
      project = App.collection.project.get(projectId),
      workflowHref = project.attributes._links.workflow.href,
      workflowId = workflowHref.substring(workflowHref.lastIndexOf('/') + 1),
      allowedTransitions = [];
    App.collection.workflow.get(workflowId)
      .attributes.status_transitions.forEach((transition) => {
        transition.initial_states.forEach((state) => {
          if (state.id === this.get('status').id) {
            allowedTransitions.push(transition);
          }
        });
      });

    return allowedTransitions;
  }
}
