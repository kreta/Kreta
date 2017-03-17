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
import OrganizationRoot from './views/page/organization/Root';
import OrganizationNew from './views/page/organization/New';
import OrganizationShow from './views/page/organization/Show';
import Profile from './views/page/profile/Edit';
import ProjectNew from './views/page/project/New';
import ProjectRoot from './views/page/project/Root';
import ProjectSettings from './views/page/project/Settings';
import ProjectShow from './views/page/project/TaskList';
import RegisterPage from './views/page/Register';
import RequestResetPasswordPage from './views/page/RequestResetPassword';
import ResetPasswordPage from './views/page/ResetPassword';

const
  routes = {
    organization: {
      new: () => ('/organizations/new'),
      show: (organization) => (`/${organization}`),
      settings: (organization) => (`/${organization}/settings`),
    },
    project: {
      new: (organization) => (`/${organization}/projects/new`),
      edit: (organization, project) => (`/${organization}/${project}/edit`),
      settings: (organization, project) => (`/${organization}/${project}/settings`),
      show: (organization, project) => (`/${organization}/${project}`),
    },
    task: {
      new: (organization, project) => (`/${organization}/${project}/tasks/new`),
      edit: (organization, project, task) => (`/${organization}/${project}/${task}/edit`),
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
    requestResetPassword: '/reset-password',
    resetPassword: '/change-password',
    home: '/'
  },
  requireAuth = (nextState, replace) => {
    if (!Security.isLoggedIn()) {
      replace({
        pathname: routes.login,
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
      <Route component={RequestResetPasswordPage} path={routes.requestResetPassword}/>
      <Route component={ResetPasswordPage} path={routes.resetPassword}/>
      <Route component={RegisterPage} onEnter={loggedRedirect} path={routes.register}/>
      <Route component={BaseLayout} onEnter={requireAuth} path={routes.home}>
        <IndexRoute component={Dashboard}/>

        <Route component={Dashboard} path={routes.search()}/>

        <Route component={OrganizationNew} path={routes.organization.new()}/>

        <Route component={OrganizationRoot}>
          <Route component={OrganizationShow} path={routes.organization.show(':organization')}/>

          <Route component={ProjectNew} path={routes.project.new(':organization')}/>
          <Route component={ProjectRoot}>
            <Route component={ProjectSettings} path={routes.project.settings(':organization', ':project')}/>
            <Route component={TaskNew} path={routes.task.new(':organization', ':project')}/>
            <Route component={TaskEdit} path={routes.task.edit(':organization', ':project', ':task')}/>
            <Route component={ProjectShow} path={routes.project.show(':organization', ':project')}>
              <Route component={TaskShow} path={routes.task.show(':organization', ':project', ':task')}/>
            </Route>
          </Route>
        </Route>

        <Route component={Profile} path={routes.profile.show()}/>

        <Route component={OrganizationShow} path={routes.organization.show(':organization')}/>
      </Route>
    </div>
  );

export {
  routes,
  sitemap
};
