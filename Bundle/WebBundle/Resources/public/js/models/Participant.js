/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import Backbone from 'backbone';

export class Participant extends Backbone.Model {
  toString() {
    return `${this.get('user').first_name} ${this.get('user').last_name}`;
  }
}
