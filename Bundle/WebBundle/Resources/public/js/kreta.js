/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {TooltipView} from 'views/component/tooltip';
import {App} from 'app';

'use strict';

$(() => {
  window.App = new App({
    onLoad: function () {
      window.App.loadLayout();
      new TooltipView();
      Backbone.history.start({pushState: true});
    }
  });

  $(document).on('click', 'a:not([data-bypass])', function (evt) {
    var href = $(this).attr('href');
    var protocol = this.protocol + '//';

    if (href && href.slice(protocol.length) !== protocol) {
      evt.preventDefault();
      window.App.router.base.navigate(href, true);
    }
  });
});
