/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */


//import {TooltipView} from 'views/component/tooltip';
import {App} from './app';
import {BaseLayout} from './views/layout/base.js';
import {ProjectShow} from './views/page/project/issueList.js';
import {ProjectSettings} from './views/page/project/settings.js';
import {Profile} from './views/page/user/edit.js';

$(() => {
  window.App = new App({
    onLoad: () => {
      //new TooltipView();
      window.React = React;

      React.render(
        <Router>
          <Route path="/" component={BaseLayout}>
            /*<Route path="issue/new" component={IssueNew}/>*/
            <Route path="project/:projectId" component={ProjectShow}/>
            <Route path="project/:projectId/settings" component={ProjectSettings}/>
            <Route path="profile" component={Profile}/>
          </Route>
        </Router>
        , document.getElementById('application')
      );
    }
  });
});
