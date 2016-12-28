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
import Dashboard from './views/page/Dashboard';
import TaskNew from './views/page/task/New';
import TaskEdit from './views/page/task/Edit';
import TaskShow from './views/page/task/Show';
import LoginPage from './views/page/Login';
import OrganizationNew from './views/page/organization/New';
import Profile from './views/page/profile/Edit';
import ProjectNew from './views/page/project/New';
import ProjectRoot from './views/page/project/Root';
import ProjectSettings from './views/page/project/Settings';
import ProjectShow from './views/page/project/TaskList';
import Security from './api/rest/User/Security';

const
  requireAuth = (nextState, replace) => {
    if (!Security.isLoggedIn()) {
      replace({
        pathname: '/login',
        state: {nextPathname: nextState.location.pathname}
      });
    }
  },
  loggedRedirect = (nextState, replace) => {
    if (Security.isLoggedIn()) {
      replace({
        pathname: '/',
        state: {nextPathname: nextState.location.pathname}
      });
    }
  };

export default (
  <div>
    <Route component={LoginPage} onEnter={loggedRedirect} path="/login"/>
    <Route component={BaseLayout} onEnter={requireAuth} path="/">
      <IndexRoute component={Dashboard}/>

      <Route component={ProjectNew} path="project/new"/>
      <Route component={ProjectRoot}>
        <Route component={TaskNew} path="project/:projectId/task/new"/>
        <Route component={ProjectShow} path="project/:projectId">
          <Route component={TaskShow} path="task/:taskId"/>
          <Route component={TaskEdit} path="task/:taskId/edit"/>
        </Route>
        <Route component={ProjectSettings} path="project/:projectId/settings"/>
      </Route>

      <Route component={OrganizationNew} path="organization/new"/>

      <Route component={Profile} path="profile"/>
    </Route>
  </div>
);
