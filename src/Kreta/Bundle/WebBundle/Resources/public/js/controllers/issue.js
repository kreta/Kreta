/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {IssueShowView} from '../views/page/issue/show';
import {IssueNewView} from '../views/page/issue/new';
import {Issue} from '../models/issue';

export class IssueController extends Backbone.Controller {
  initialize() {
    this.routes = {
      'issue/:issue': 'showAction',
      'issue/:id/edit': 'editAction',
      'issue/new': 'newAction'
    };
  }

  newAction() {
    var view = new IssueNewView();
    App.views.main.render(view.render().el);
    Backbone.trigger('main:full-screen');
  }

  editAction(id) {
    var issue = new Issue({id: id});
    var view = new IssueNewView({issue: issue});

    App.views.main.render(view.render().el);
    Backbone.trigger('main:full-screen');
  }

  showAction(issue) {
    if(issue instanceof Issue) {
      var model = issue;
    } else {
      var model = new Issue({id: issue});
      model.fetch();
    }

    var view = new IssueShowView({model: model});
    view.show();
  }
}
