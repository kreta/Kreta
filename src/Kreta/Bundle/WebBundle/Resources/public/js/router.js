/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {IssueController} from 'controllers/issue';
import {ProjectController} from 'controllers/project';

export class Router extends Backbone.Router {
  constructor () {
    var router = this;
    $(document).on('click', 'a:not([data-bypass])', function (evt) {
      var href = $(this).attr('href');
      var protocol = this.protocol + '//';

      if (href && href.slice(protocol.length) !== protocol) {
        evt.preventDefault();
        router.navigate(href, true);
      }
    });

    this.routes = {
      '': 'showIndex'
    };

    App.controller.issue = new IssueController({router: true});
    App.controller.project = new ProjectController({router: true});

    this._bindRoutes();
  }

  showIndex () {
  }
}
