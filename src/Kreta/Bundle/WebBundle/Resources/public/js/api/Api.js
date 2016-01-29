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

function _getCookie(name) {
  var value = `; ${document.cookie}`,
    parts = value.split(`; ${name}=`);

  if (parts.length === 2) {
    return parts.pop().split(';').shift();
  }
}

class Api {
  constructor() {
    if (new.target === Api) {
      throw new TypeError('Api is an abstract class, it cannot be instantiate');
    }
  }

  baseUrl() {
    return Config.baseUrl;
  }

  accessToken() {
    return _getCookie('access_token');
  }

  get(url) {
    return fetch(`${this.baseUrl()}${url}`, {
      credentials: 'include',
      headers: {
        'Authorization': `Bearer ${this.accessToken()}`
      },
      method: 'get',
      mode: 'cors'
    }).then((response) => {
      return response.json();
    });
  }

  post(url, payload) {
    return fetch(`${this.baseUrl()}${url}`, {
      body: payload,
      credentials: 'include',
      headers: {
        'Authorization': `Bearer ${this.accessToken()}`,
        'Content-type': 'application/json'
      },
      method: 'post',
      mode: 'cors'
    }).then((response) => {
      return response.json();
    });
  }
}

export default Api;
