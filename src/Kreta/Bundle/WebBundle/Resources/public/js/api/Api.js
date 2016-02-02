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

import $ from 'jquery';

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

function _json(response) {
  const json = response.json();
  if (response.status >= 400) {
    throw json;
  }

  return json;
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
    }).then(_json);
  }

  post(url, payload) {
    return fetch(`${this.baseUrl()}${url}`, {
      body: _toFormData(payload),
      credentials: 'include',
      headers: {
        'Authorization': `Bearer ${this.accessToken()}`
      },
      method: 'post'
    }).then(_json);
  }

  put(url, payload) {
    return new Promise((resolve, reject) => {
      const request = new XMLHttpRequest();
      request.open('PUT', `${this.baseUrl()}${url}`);
      request.setRequestHeader('Content-Type', 'application/json');
      request.setRequestHeader('Authorization', `Bearer ${this.accessToken()}`);

      request.send(JSON.stringify({
        project: "df57de8c-c335-11e5-857e-de3e9a4cad7e",
        title: "Issue",
        assignee: "cec55e3c-c335-11e5-857e-de3e9a4cad7e",
        priority: "df581c8a-c335-11e5-857e-de3e9a4cad7e",
        description: "OLAAAA"
      }));

      request.onload = () => {
        const body = new Blob();
        if (request.status == 200) {
          // Resolve the promise with the response text
          resolve(request.response);
        }
        else {
          // Otherwise reject with the status text
          // which will hopefully be a meaningful error
          reject(_json(
            new Response(body, {
              status: request.status,
              statusText: JSON.parse(request.response)
            })));
        }


//        const body = new Blob();
//
//        return _json(
//          new Response(body, {
//            status: request.status,
//            statusText: JSON.parse(request.response)
//          })
//        );
      };

      request.send();
    });

//    var xhr = new XMLHttpRequest();
//    xhr.open('PUT', `${this.baseUrl()}${url}`);
//    xhr.setRequestHeader('Content-Type', 'application/json');
//    xhr.setRequestHeader('Authorization', `Bearer ${this.accessToken()}`);
//    xhr.onload = function() {
//      if (xhr.status === 200) {
//        return Promise.JSON.parse(xhr.responseText);
//      }
//    };
//
//    xhr.send(JSON.stringify({
//      project: "df57de8c-c335-11e5-857e-de3e9a4cad7e",
//      title: "Issue",
//      assignee: "cec55e3c-c335-11e5-857e-de3e9a4cad7e",
//      priority: "df581c8a-c335-11e5-857e-de3e9a4cad7e",
//      description: "OLAAAA"
//    }));
//
//    return fetch(`${this.baseUrl()}${url}`, {
//      body: _toFormData(
//        {
//          "project": "df57de8c-c335-11e5-857e-de3e9a4cad7e",
//          "title": "Issue",
//          "assignee": "cec55e3c-c335-11e5-857e-de3e9a4cad7e",
//          "priority": "df581c8a-c335-11e5-857e-de3e9a4cad7e",
//          "description": "dsfdsgdfsgsgsfg"
//        }
//      ),
//      credentials: 'include',
//      headers: {
//        'Authorization': `Bearer ${this.accessToken()}`,
////        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
//        'Content-Type': 'application/json',
//        'X-Requested-With': 'XMLHttpRequest'
//      },
//      method: 'PUT'
//    }).then(_json);
  }

  deleteHttp(url) { // Http sufix is needed because delete is a reserved word
    return fetch(`${this.baseUrl()}${url}`, {
      credentials: 'include',
      headers: {
        'Authorization': `Bearer ${this.accessToken()}`
      },
      method: 'delete'
    }).then(_json);
  }
}

export default Api;
