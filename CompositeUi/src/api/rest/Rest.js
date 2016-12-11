/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Rest {
  constructor() {
    if (this.constructor.name === 'Rest') {
      throw new TypeError('Rest is an abstract class, it cannot be instantiate directly');
    }

    this.accessToken = () => (
      localStorage.token
    );

    this.request = (method, url, body = {}, headers = {}) => (
      new Promise((resolve, reject) => {
        fetch(`${this.baseUrl()}${url}`, {body, headers, method})
          .then((response) => {
            if (response.ok) {
              resolve(response.json());
            } else {
              reject(response.json());
            }
          });
      })
    );

    this.toQueryParams = (query = null) => {
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
    };

    this.toFormData = (body) => {
      const data = new FormData();
      for (const key in body) {
        if (body.hasOwnProperty(key)) {
          data.append(key, body[key]);
        }
      }

      return data;
    };
  }

  baseUrl() {
    throw new Error('"baseUrl" is an abstract method that expects to be implemented by children classes');
  }

  get(url, query = null, headers) {
    return this.request('GET', `${url}${this.toQueryParams(query)}`, {}, headers);
  }

  post(url, payload = {}, headers = {}) {
    return this.request('POST', url, this.toFormData(payload), headers);
  }

  put(url, payload = {}, headers = {}) {
    return this.request('PUT', url, this.toFormData(payload), headers);
  }

  deleteHttp(url, headers) { // Http suffix is needed because delete is a reserved word
    return this.request('DELETE', url, {}, headers);
  }
}

export default Rest;
