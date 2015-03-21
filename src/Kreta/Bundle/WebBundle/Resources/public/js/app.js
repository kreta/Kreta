/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {HeaderView} from 'views/header';
import {MainView} from 'views/main';
import {LeftAsideView} from 'views/aside/leftAside';
import {RightAsideView} from 'views/aside/rightAside';
import {UserCollection} from 'collections/user';
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
  $.ajaxSetup({
    headers: {'Authorization': 'Bearer ' + App.accessToken}
  });

  new Router();
  new HeaderView();

  App.views.main = new MainView();
  App.views.leftAside = new LeftAsideView();
  App.views.rightAside = new RightAsideView();

  Backbone.history.start({pushState: true});
});

