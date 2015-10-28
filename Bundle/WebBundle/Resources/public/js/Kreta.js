/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import React from 'react';
import {Router, Route} from 'react-router';
import $ from 'jquery';

// import {TooltipView} from 'views/component/tooltip';
import {App} from './App';
import BaseLayout from './views/layout/Base';
import ProjectNew from './views/page/project/New.js';
import ProjectShow from './views/page/project/IssueList.js';
import ProjectSettings from './views/page/project/Settings.js';
import Profile from './views/page/user/Edit.js';
import IssueNew from './views/page/issue/New.js';

$(() => {
  window.App = new App({
    onLoad: () => {
      // new TooltipView();
      window.React = React;

      React.render(
        <Router>
          <Route component={BaseLayout} path="/">
            <Route component={IssueNew} path="issue/new"/>
            <Route component={IssueNew} path="issue/new/:projectId"/>

            <Route component={ProjectNew} path="project/new"/>
            <Route component={ProjectShow} path="project/:projectId"/>
            <Route component={ProjectSettings} path="project/:projectId/settings"/>

            <Route component={Profile} path="profile"/>
          </Route>
        </Router>
        , document.getElementById('application')
      );
    }
  });
});
