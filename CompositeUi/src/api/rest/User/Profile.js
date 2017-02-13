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

class Profile {
  get() {
    return IdentityAccessRest.get('/user');
  }

  update(profileData) {
    return IdentityAccessRest.post('/user', {
      email: profileData.email,
      username: profileData.username,
      firstName: profileData.first_name,
      lastName: profileData.last_name
    });
  }
}

const instance = new Profile();

export default instance;
