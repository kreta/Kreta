/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {HeaderView} from 'views/layout/mainMenu';
import {MainView} from 'views/layout/mainContent';
import {LeftAsideView} from 'views/layout/leftAside';
import {RightAsideView} from 'views/layout/rightAside';
import {Router} from 'router';
import {Config} from 'config';

var App = {
  views: {},
  collections: {},
  config: new Config(),
  accessToken: 'dummy-access-token'
};

window.App = App;

$(() => {
  'use strict';

  Backbone.$.ajaxSetup({
    headers: {'Authorization': 'Bearer ' + App.accessToken}
  });

  new Router();
  new HeaderView();

  App.views.main = new MainView();
  App.views.leftAside = new LeftAsideView();
  App.views.rightAside = new RightAsideView();

  Backbone.history.start({pushState: true});
});

