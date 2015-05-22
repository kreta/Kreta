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

export class IssueController extends Backbone.Marionette.Controller {
  newAction() {
    App.layout.getRegion('content').show(new IssueNewView({model: new Issue()}));
    Backbone.trigger('main:full-screen');
  }

  editAction(issue) {
    App.layout.getRegion('content').show(new IssueNewView({model: this.getCurrentIssue(issue)}));
    Backbone.trigger('main:full-screen');
  }

  showAction(issue) {
    App.layout.getRegion('content').show(new IssueShowView({model: this.getCurrentIssue(issue)}));
    Backbone.trigger('main:full-screen');
  }

  getCurrentIssue(issue) {
    var model = issue;
    if(!(issue instanceof Issue)) {
      model = new Issue({id: issue});
      model.fetch();
    }

    return model;
  }
}
