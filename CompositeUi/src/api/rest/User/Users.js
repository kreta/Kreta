/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import IdentityAccessRest from './../IdentityAccessRest';

class Users {
  get(ids) {
    return IdentityAccessRest.get('/users', ids);
  }

  search(query) {
    return IdentityAccessRest.get('/q', query);
  }
}

const instance = new Users();

export default instance;
