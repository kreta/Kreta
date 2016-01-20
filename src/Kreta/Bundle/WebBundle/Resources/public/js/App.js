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
import Notifications from './collections/Notifications';
import Profile from './models/Profile';
import Projects from './collections/Projects';
import Users from './collections/Users';
import Workflows from './collections/Workflows';

class App {
  constructor(options) {
    this.options = options;

    this.addAutenticationHeader();

    this.collection = {
      project: new Projects(),
      user: Users,
      workflow: new Workflows(),
      notification: new Notifications()
    };

    this.currentUser = new Profile();

    this.dependenciesToLoad = 4;
    this.currentUser.fetch({
      success: $.proxy(this.dependencyLoaded, this)
    });
    this.collection.project.fetch({
      success: $.proxy(this.dependencyLoaded, this)
    });
    this.collection.user.fetch({
      success: $.proxy(this.dependencyLoaded, this)
    });
    this.collection.workflow.fetch({
      success: $.proxy(this.dependencyLoaded, this)
    });
  }

  dependencyLoaded() {
    this.dependenciesToLoad--;
    if (this.dependenciesToLoad === 0) {
      this.options.onLoad();
    }
  }

  loadLayout() {
    this.layout = new BaseLayoutView();
    this.layout.render();

    new HeaderView();
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
