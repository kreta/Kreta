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

class Projects extends Backbone.Collection {
  model = Project;

  url() {
    return `${Config.baseUrl}/projects`;
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

export default Projects;
