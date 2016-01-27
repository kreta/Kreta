import React from 'react';
import { IndexRoute, Route }        from 'react-router';
import BaseLayout from './views/layout/Base';
import IssueNew from './views/page/issue/New';
import Profile from './views/page/user/Edit';
import ProjectNew from './views/page/project/New';
import ProjectSettings from './views/page/project/Settings';
import ProjectShow from './views/page/project/IssueList';
import Index from './views/page/Index';

export default (
  <Route component={BaseLayout} path="/">
    <IndexRoute component={Index}/>

    <Route component={IssueNew} path="issue/new"/>
    <Route component={IssueNew} path="issue/new/:projectId"/>

    <Route component={ProjectNew} path="project/new"/>
    <Route component={ProjectShow} path="project/:projectId"/>
    <Route component={ProjectSettings} path="project/:projectId/settings"/>

    <Route component={Profile} path="profile"/>
  </Route>
);
