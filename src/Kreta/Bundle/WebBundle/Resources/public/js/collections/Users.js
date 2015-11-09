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
import User from './../models/User';

class Users extends Backbone.Collection {
  model = User;

  url() {
    return `${Config.baseUrl}/users`;
  }
}

export default Users;
