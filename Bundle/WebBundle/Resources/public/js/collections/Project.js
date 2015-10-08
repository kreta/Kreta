/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import Backbone from 'backbone';
import {Config} from '../Config';
import {Project} from '../models/Project';

export class ProjectCollection extends Backbone.Collection {
  constructor(models, options = {}) {
    _.defaults(options, {
      model: Project
    });
    super(models, options);
  }

  url() {
    return `${Config.baseUrl}/projects`;
  }

  filter(name) {
    var filtered = [];
    this.models.forEach((model) => {
      if (model.get('name').indexOf(name) > -1) {
        filtered.push(model.toJSON());
      }
    });
    return new ProjectCollection(filtered);
  }
}
