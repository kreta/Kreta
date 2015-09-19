/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class MainContentRegion extends Backbone.Marionette.Region {
  constructor(options) {
    this.el = '.kreta-content-container';

    App.vent.on('left-aside:after-open', () => {
      this.leftOpened();
    });
    App.vent.on('left-aside:close', () => {
      this.leftClosed();
    });

    App.vent.on('right-aside:after-open', () => {
      this.rightOpened();
    });
    App.vent.on('right-aside:close', () => {
      this.rightClosed();
    });

    super(options);
  }

  leftOpened() {
    this.$el.parent().addClass('left-open');
  }

  leftClosed() {
    this.$el.parent().removeClass('left-open');
  }

  rightOpened() {
    this.$el.parent().addClass('right-open');
  }

  rightClosed() {
    this.$el.parent().removeClass('right-open');
  }
}
