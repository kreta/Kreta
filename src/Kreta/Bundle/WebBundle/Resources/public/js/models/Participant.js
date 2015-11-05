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

class Participant extends Backbone.Model {
  toString() {
    return `${this.get('user').first_name} ${this.get('user').last_name}`;
  }
}

export default Participant;
