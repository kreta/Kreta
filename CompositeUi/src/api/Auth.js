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
  static auth(username, password) {
    return fetch(`${Config.identityAccessUrl}/auth/token`, {
      headers: {
        'Authorization': `Basic ${btoa(`${username}:${password}`)}`,
      },
      method: 'POST'
    }).then(response => {
      if (response.status >= 400) {
        const error = new Error(response.statusText);
        error.response = response;
        throw error;
      }

      return response;
    }).then(response => (
      response.json()
    )).then(data => {
      console.log(data);
    }).catch(error => {
      console.error(error);
    });
  }

  invite() {

  }
}

export default Auth;
