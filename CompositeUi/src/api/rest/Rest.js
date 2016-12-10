/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Config from '../../Config';

const
  toQueryParams = (query = null) => {
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
  },
  toFormData = (body) => {
    const data = new FormData();
    for (const key in body) {
      if (body.hasOwnProperty(key)) {
        data.append(key, body[key]);
      }
    }

    return data;
  },
  json = (response) => {
    if (response.status >= 400) {
      throw Error({
        status: response.status,
        data: response.json
      });
    }

    return {
      status: response.status,
      data: response.json
    };
  };

class Rest {
  constructor() {
    if (new.target === Rest) {
      throw new TypeError('Api is an abstract class, it cannot be instantiate');
    }
  }

  baseUrl() {
    return Config.taskManagerUrl;
  }

  accessToken() {
    return localStorage.token;
  }

  get(url, query = null) {
    return fetch(`${this.baseUrl()}${url}${toQueryParams(query)}`, {
      credentials: 'include',
      headers: {
        'Authorization': `Bearer ${this.accessToken()}`
      },
      method: 'get'
    }).then(json);
  }

  post(url, payload) {
    return fetch(`${this.baseUrl()}${url}`, {
      body: toFormData(payload),
      credentials: 'include',
      headers: {
        'Authorization': `Bearer ${this.accessToken()}`
      },
      method: 'post'
    }).then(json);
  }

  put(url, payload) {
    return fetch(`${this.baseUrl()}${url}`, {
      body: toFormData(payload),
      credentials: 'include',
      headers: {
        'Authorization': `Bearer ${this.accessToken()}`
      },
      method: 'put'
    }).then(json);
  }

  deleteHttp(url) { // Http suffix is needed because delete is a reserved word
    return fetch(`${this.baseUrl()}${url}`, {
      credentials: 'include',
      headers: {
        'Authorization': `Bearer ${this.accessToken()}`
      },
      method: 'delete'
    }).then(json);
  }
}

export default Rest;
