/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {IssueAsideView} from 'views/aside/right/issueAside';
import {MiniIssueList} from 'views/main/miniIssueList';
import {CreateIssueView} from 'views/main/createIssue';

export class Router extends Backbone.Router {
  constructor () {
    var router = this;
    $(document).on('click', 'a:not([data-bypass])', function (evt) {
      var href = $(this).attr('href');
      var protocol = this.protocol + '//';

      if (href.slice(protocol.length) !== protocol) {
        evt.preventDefault();
        router.navigate(href, true);
      }
    });

    this.routes = {
      '': 'showIndex',
      'issue/new': 'createIssue',
      'issue/:id': 'showIssue',
      'projects': 'showProjects',
      'project/:id': 'showProject'
    };

    this._bindRoutes();
  }

  showIndex () {
    App.views.leftAside.hide();
    App.views.rightAside.hide();
  }

  showIssue (id) {
    var view = new IssueAsideView({id: id});
    App.views.rightAside.show(view.render().el);
  }

  showProjects () {
    App.views.rightAside.hide();
    App.views.leftAside.showProjects();
  }

  showProject (id) {
    var view = new MiniIssueList({projectId: id});
    App.views.main.render(view.render().el);
    App.views.leftAside.hide();
    App.views.rightAside.hide();
  }

  createIssue () {
    var view = new CreateIssueView();
    App.views.main.render(view.render().el);
    App.views.leftAside.hide();
    App.views.rightAside.hide();
  }
}
