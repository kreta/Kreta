import React from 'react';
import { IndexRoute, Route } from 'react-router';
import BaseLayout from './views/layout/Base';
import IssueNew from './views/page/issue/New';
import Profile from './views/page/profile/Edit';
import ProjectRoot from './views/page/project/Root';
import ProjectNew from './views/page/project/New';
import ProjectSettings from './views/page/project/Settings';
import ProjectShow from './views/page/project/IssueList';
import OrganizationRoot from './views/page/organization/Root';
import Index from './views/page/Index';

export default (
  <Route component={BaseLayout} path="/">
    <IndexRoute component={Index}/>

    <Route component={Profile} path="profile"/>

    <Route component={OrganizationRoot} path=":organization">
      <IndexRoute component={Index}/>
      <Route component={ProjectNew} path="project/new"/>
      <Route component={ProjectRoot}>
        <Route component={ProjectShow} path=":project"/>
        <Route component={IssueNew} path=":project/issue/new"/>
        <Route component={ProjectShow} path=":project/issue/:issueId"/>
        <Route component={ProjectSettings} path=":project/settings"/>
      </Route>
    </Route>


  </Route>
);
