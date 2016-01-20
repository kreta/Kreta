/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Backbone from 'backbone';

import Config from './../Config';
import Project from './../models/Project';
import ActionTypes from '../constants/ActionTypes';
import Store from '../stores/Store';

class Projects extends Store.Collection {
  model = Project;

  url() {
    return `${Config.baseUrl}/projects`;
  }

  handleDispatch(payload) {
    switch (payload.type) {

      case ActionTypes.PROJECT_CREATE:
        this.create(payload.issue, {
          success: (model) => {
            this.emitter.emit(ActionTypes.PROJECT_CREATED, model);
          },
          error: (model, errors) => {
            this.emitter.emit(ActionTypes.PROJECT_CREATE_ERROR, errors)
          }
        });

        break;

      default:
        return true;
    }
  }

  filter(name) {
    let filtered = [];
    this.models.forEach((model) => {
      if (model.get('name').indexOf(name) > -1) {
        filtered.push(model.toJSON());
      }
    });

    return new Projects(filtered);
  }
}

let ProjectsCollection = new Projects();

export default ProjectsCollection;
