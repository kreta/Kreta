/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import '../../../scss/layout/_aside.scss';

export class AsideRegion extends Backbone.Marionette.Region {
  constructor(options = {}) {
    _.defaults(options, {
      position: options.position,
      el: `.${options.position}-aside`
    });
    super(options);

    App.vent.bind('aside:before-open', () => {
      this.hide();
    });
    App.vent.bind('main:full-screen', () => {
      this.hide();
    });
  }

  onShow() {
    App.vent.trigger('aside:before-open');

    setTimeout(() => {
      this.$el.children().addClass('visible');
      App.vent.trigger(`${this.position}-aside:after-open`);
    }, 1);

  }

  hide() {
    if (this.$el.children().hasClass('visible')) {
      this.$el.children().removeClass('visible');
      App.vent.trigger(`${this.position}-aside:close`);

      setTimeout(() => { // Wait animation
        this.destroy();
      }, 500);
    }
  }
}
