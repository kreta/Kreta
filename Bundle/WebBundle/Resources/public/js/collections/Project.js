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
