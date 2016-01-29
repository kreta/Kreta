/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Api from './Api';

class ProfileApi extends Api {
  getProfile() {
    return this.get('/profile');
  }

  postProfile(profile) {
    return this.post('/profile', profile);
  }
}

const instance = new ProfileApi();

export default instance;
