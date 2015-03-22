/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class RightAsideView extends Backbone.View {
  constructor () {
    this.setElement($('#kreta-right-aside'), true);

    super();
  }

  show ($el) {
    this.hide();
    this.$el.append($el);

    setTimeout(function () {
      App.views.main.rightOpened();
      $($el).addClass('visible');
    }, 1);
  }

  hide () {
    var $menusToHide = this.$el.children('div');
    $menusToHide.removeClass('visible');
    App.views.main.rightClosed();
    setTimeout(function () {
      $menusToHide.remove();
    }, 500);
  }
}
