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

import Security from './api/rest/User/Security';

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
import RegisterPage from './views/page/Register';
import ResetPasswordPage from './views/page/ResetPassword';

const
  routes = {
    organization: {
      new: () => ('/organizations/new'),
      edit: (organization) => (`/organizations/${organization}/edit`),
      show: (organization) => (`/${organization}`),
    },
    project: {
      new: (organization) => (`/organizations/${organization}/projects/new`),
      edit: (organization, project) => (`/organizations/${organization}/projects/${project}/edit`),
      settings: (organization, project) => (`/organizations/${organization}/projects/${project}/settings`),
      show: (organization, project) => (`/${organization}/${project}`),
    },
    task: {
      new: (organization, project) => (`/organizations/${organization}/projects/${project}/tasks/new`),
      edit: (organization, project, task) => (`/organizations/${organization}/projects/${project}/tasks/${task}/edit`),
      show: (organization, project, task) => (`/${organization}/${project}/${task}`),
    },
    profile: {
      edit: () => ('/profile'),
      show: () => ('/profile')
    },
    search: (query = null) => {
      if (null === query) {
        return '/search';
      }

      return {pathname: '/search', query: {q: query}};
    },
    login: '/login',
    register: '/join',
    resetPassword: '/reset-password',
    home: '/'
  },
  requireAuth = (nextState, replace) => {
    if (!Security.isLoggedIn()) {
      replace({
        pathname: routes.security.login(),
        state: {nextPathname: nextState.location.pathname}
      });
    }
  },
  loggedRedirect = (nextState, replace) => {
    if (Security.isLoggedIn()) {
      replace({
        pathname: routes.home,
        state: {nextPathname: nextState.location.pathname}
      });
    }
  },
  sitemap = (
    <div>
      <Route component={LoginPage} onEnter={loggedRedirect} path={routes.login}/>
      <Route component={ResetPasswordPage} onEnter={loggedRedirect} path={routes.resetPassword}/>
      <Route component={RegisterPage} onEnter={loggedRedirect} path={routes.register}/>
      <Route component={BaseLayout} onEnter={requireAuth} path={routes.home}>
        <IndexRoute component={Dashboard}/>

        <Route component={Dashboard} path={routes.search()}/>

        <Route component={OrganizationNew} path={routes.organization.new()}/>

        <Route component={ProjectNew} path={routes.project.new(':organization')}/>
        <Route component={ProjectRoot}>
          <Route component={TaskNew} path={routes.task.new(':organization', ':project')}/>
          <Route component={ProjectShow} path={routes.project.show(':organization', ':project')}>
            <Route component={TaskShow} path={routes.task.show(':organization', ':project', ':task')}/>
            <Route component={TaskEdit} path={routes.task.edit(':organization', ':project', ':task')}/>
          </Route>
          <Route component={ProjectSettings} path={routes.project.settings(':organization', ':project')}/>
        </Route>

        <Route component={Profile} path={routes.profile.show()}/>
      </Route>
    </div>
  );

export {
  routes,
  sitemap
};
