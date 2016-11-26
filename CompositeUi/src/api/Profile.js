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
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve({
          "id": "0",
          "username": "user",
          "email": "user@kreta.com",
          "enabled": true,
          "last_login": null,
          "created_at": "2014-10-20T00:00:00+0200",
          "first_name": "Kreta",
          "last_name": "User",
          "photo": {},
          "_links": {
            "self": {
              "href": "http://kreta.test:8000/api/profile"
            },
            "projects": {
              "href": "http://kreta.test:8000/api/projects"
            }
          }
        });
      }, 400);
    });
  }

  putProfile(profile) {
    return this.post('/profile', profile);
  }
}

const instance = new ProfileApi();

export default instance;
