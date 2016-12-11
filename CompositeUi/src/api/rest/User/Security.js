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

class Security {
  login(email, password) {
    return IdentityAccessRest.post('/auth/token', {}, {
      'Authorization': `Basic ${btoa(`${email}:${password}`)}`
    });
  }

  logout() {
    return new Promise((resolve) => {
      localStorage.removeItem('token');

      setTimeout(() => {
        resolve();
      }, 600);
    });
  }

  isLoggedIn() {
    return !!localStorage.token;
  }
}

const instance = new Security();

export default instance;
