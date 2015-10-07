  /*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import React from 'react';
import {Router, Route} from 'react-router';

// import {TooltipView} from 'views/component/tooltip';
import {App} from './app';
import BaseLayout from './views/layout/base';
import ProjectShow from './views/page/project/issueList.js';
import ProjectSettings from './views/page/project/settings.js';
import Profile from './views/page/user/edit.js';
import IssueNew from './views/page/issue/new.js';


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
