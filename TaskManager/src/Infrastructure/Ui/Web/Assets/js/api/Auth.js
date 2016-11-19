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

export default class Auth {
  static auth(username, password) {
    return fetch(`${Config.baseUrl}/auth/token`, {
      headers: {
        'Authorization': `Basic ${btoa(`${username}:${password}`)}`
      },
      method: 'POST'
    }).then(response => {
      console.log(response);
      const json = response.json();
      if (response.status >= 400) {
        throw json;
      }
      return json;
    });
  }

  invite() {

  }
}
