/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../scss/app.scss';

import {ProjectController} from './controllers/Project';
import {IssueController} from './controllers/Issue';

import {ProjectCollection} from './collections/Project';
import {UserCollection} from './collections/User';
import {WorkflowCollection} from './collections/Workflow';

import {Profile} from './models/Profile';

import {BaseLayoutView} from './views/layout/Base';
import {HeaderView} from './views/layout/MainMenu';

export class App extends Backbone.Marionette.Application {
  constructor(options) {
    super(options);

    this.addAutenticationHeader();

    this.controller = {
      issue: new IssueController(),
      project: new ProjectController()
    };

    this.collection = {
      project: new ProjectCollection(),
      user: new UserCollection(),
      workflow: new WorkflowCollection()
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
