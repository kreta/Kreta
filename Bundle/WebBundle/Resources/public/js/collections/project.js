/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Config} from '../config';
import {Project} from '../models/project';

export class ProjectCollection extends Backbone.Collection {
  constructor() {
    this.model = Project;
    this.url = `${Config.baseUrl}/projects`;

    super();
  }

  filterByName(name) {
    var filtered = [];
    this.models.forEach((model) => {
      if (model.get('name').indexOf(name) > -1) {
        filtered.push(model.toJSON());
      }
    });
    return filtered;
  }
}
