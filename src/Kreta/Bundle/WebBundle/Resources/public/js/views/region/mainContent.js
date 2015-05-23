/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class MainContentRegion extends Backbone.Marionette.Region {
  constructor (options) {
    this.el = '.kreta-content-container';

    super(options);

    this.listenTo(Backbone, 'left-aside:after-open', this.leftOpened);
    this.listenTo(Backbone, 'left-aside:close', this.leftClosed);

    this.listenTo(Backbone, 'right-aside:after-open', this.rightOpened);
    this.listenTo(Backbone, 'right-aside:close', this.rightClosed);
  }

  leftOpened () {
    this.$el.parent().addClass('left-open');
  }

  leftClosed () {
    this.$el.parent().removeClass('left-open');
  }

  rightOpened () {
    this.$el.parent().addClass('right-open');
  }

  rightClosed () {
    this.$el.parent().removeClass('right-open');
  }
}
