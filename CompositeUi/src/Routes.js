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
import {IndexRoute, Route} from 'react-router';

import BaseLayout from './views/layout/Base';
import Index from './views/page/Index';
import IssueNew from './views/page/issue/New';
import LoginPage from './views/page/Login';
import Profile from './views/page/profile/Edit';
import ProjectNew from './views/page/project/New';
import ProjectRoot from './views/page/project/Root';
import ProjectSettings from './views/page/project/Settings';
import ProjectShow from './views/page/project/IssueList';
import SecurityInstance from './api/Security';

const requireAuth = (nextState, replace) => {
  if (!SecurityInstance.isLoggedIn()) {
    replace({
      pathname: '/login',
      state: {nextPathname: nextState.location.pathname}
    });
  }
};

export default (
  <div>
    <Route component={LoginPage} path="/login"/>
    <Route component={BaseLayout} onEnter={requireAuth} path="/">
      <IndexRoute component={Index}/>

      <Route component={ProjectNew} path="project/new"/>
      <Route component={ProjectRoot}>
        <Route component={ProjectShow} path="project/:projectId"/>
        <Route component={IssueNew} path="project/:projectId/issue/new"/>
        <Route component={ProjectShow} path="project/:projectId/issue/:issueId"/>
        <Route component={ProjectSettings} path="project/:projectId/settings"/>
      </Route>

      <Route component={Profile} path="profile"/>
    </Route>
  </div>
);
