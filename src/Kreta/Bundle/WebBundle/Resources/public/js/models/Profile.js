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
import Store from '../stores/Store';
import ActionTypes from '../constants/ActionTypes';

class Profile extends Store.Model {
  constructor(attributes, options = {}) {
    super(attributes, options);

    this.fileAttribute = 'photo';
  }

  urlRoot() {
    return `${Config.baseUrl}/profile`;
  }

  toString() {
    return this.get('name');
  }
}

export default Profile;
