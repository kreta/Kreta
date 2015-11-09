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
import Issue from './../models/Issue';

class Issues extends Backbone.Collection {
  model = Issue;

  url() {
    return `${Config.baseUrl}/issues`;
  }

  findIndexById(issueId) {
    var i = 0;

    while (i < this.models.length) {
      if (this.models[i].get('id') === issueId) {
        return i;
      }
      i++;
    }

    return -1;
  }
}

export default Issues;
