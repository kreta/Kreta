/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Config} from '../config';

export class Issue extends Backbone.Model {
  urlRoot() {
    return Config.baseUrl + '/issues';
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
    return this.get('assignee').id === user.id || this.get('reporter').id === user.id;
  }

  toJSON(options) {
    var data = _.clone(this.attributes);

    if (typeof(options) !== 'undefined' && options.parse) {
      data = _.omit(data, 'id');
    }

    return data;
  }

  getAllowedTransitions() {
    var projectHref = this.attributes._links.project.href;
    var projectId = projectHref.substring(projectHref.lastIndexOf('/') + 1);
    var project = App.collection.project.get(projectId);

    var workflowHref = project.attributes._links.workflow.href;
    var workflowId = workflowHref.substring(workflowHref.lastIndexOf('/') + 1);

    var allowedTransitions = [];
    App.collection.workflow.get(workflowId).attributes.status_transitions.forEach((transition) => {
      transition.initial_states.forEach((state) => {
        if(state.id === this.get('status').id) {
          allowedTransitions.push(transition);
        }
      });
    });

    return allowedTransitions;
  }
}
