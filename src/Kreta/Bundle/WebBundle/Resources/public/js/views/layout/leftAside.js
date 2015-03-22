/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {ProjectAsideView} from '../aside/left/projectAside';

export class LeftAsideView extends Backbone.View {
  constructor () {
    this.setElement($('#kreta-left-aside'), true);

    this.$projectAside = new ProjectAsideView();

    super();

    this.render();
  }

  render () {
    this.$el.append(this.$projectAside.render().el);
  }

  showProjects () {
    this.hide();

    setTimeout(() => {
      App.views.main.leftOpened();
      this.$projectAside.show();
    }, 1);
  }

  hide () {
    var $menusToHide = this.$el.children('div');
    $menusToHide.removeClass('visible');
    App.views.main.leftClosed();
  }
}
