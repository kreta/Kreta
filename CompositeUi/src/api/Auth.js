/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Config from './../Config';

class Auth {
  login(username, password) {
    return fetch(`${Config.identityAccessUrl}/auth/token`, {
      headers: {
        'Authorization': `Basic ${btoa(`${username}:${password}`)}`,
      },
      method: 'POST'
    }).then((response) => {
      const json = response.json();
      if (response.status >= 400) {
        throw json;
      }
      localStorage.token = json.token;

      return json.token;
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

  loggedIn() {
    return !!localStorage.token;
  }

  token() {
    return localStorage.token;
  }

  invite() {

  }
}

const AuthInstance = new Auth();

export default AuthInstance;
