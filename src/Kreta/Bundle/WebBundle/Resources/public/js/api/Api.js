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

function _toQueryParams(query = null) {
  if (null === query) {
    return '';
  }

  let result = '?';
  if (query instanceof Array) {
    query.map((value, key) => {
      result = `${result}${key}=${value}&`;
    });
  } else if (typeof query === 'object') {
    for (const key in query) {
      if (query.hasOwnProperty(key)) {
        result = `${result}${key}=${query[key]}&`;
      }
    }
  }

  return result;
}

function _toFormData(body) {
  const data = new FormData();
  for (const key in body) {
    if (body.hasOwnProperty(key)) {
      data.append(key, body[key]);
    }
  }

  return data;
}

function _status(response) {
  if (response.status >= 200 && response.status < 300) {
    return Promise.resolve(response);
  }
  throw Promise.resolve(response.json());
}

function _json(response) {
  return response.json();
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

  get(url, query = null) {
    return fetch(`${this.baseUrl()}${url}${_toQueryParams(query)}`, {
      credentials: 'include',
      headers: {
        'Authorization': `Bearer ${this.accessToken()}`
      },
      method: 'get'
    }).then(_status)
      .then(_json);
  }

  post(url, payload) {
    return fetch(`${this.baseUrl()}${url}`, {
      body: _toFormData(payload),
      credentials: 'include',
      headers: {
        'Authorization': `Bearer ${this.accessToken()}`
      },
      method: 'post'
    }).then(_status)
      .then(_json);
  }
}

export default Api;
