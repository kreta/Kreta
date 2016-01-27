/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import './../scss/app';

import $ from 'jquery';
import Backbone from 'backbone';

import BaseLayoutView from './views/layout/Base';
import HeaderView from './views/layout/MainMenu';

class App {
  constructor(options) {
    this.options = options;

    this.addAutenticationHeader();
  }

  addAutenticationHeader() {
    Backbone.$.ajaxSetup({
      headers: {'Authorization': `Bearer ${this.getAccessToken()}`}
    });
  }

  getCookie(name) {
    var value = `; ${document.cookie}`,
      parts = value.split(`; ${name}=`);

    if (parts.length === 2) {
      return parts.pop().split(';').shift();
    }
  }

  getAccessToken() {
    return this.getCookie('access_token');
  }
}

export default App;
