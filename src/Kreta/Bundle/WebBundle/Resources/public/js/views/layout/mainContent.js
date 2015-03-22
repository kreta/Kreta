/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class MainView extends Backbone.View {
  constructor () {
    this.setElement($('.kreta-content-container'), true);
    this.$spacer = this.$el.parent();

    super();
  }

  render (el) {
    this.$el.html(el);
  }

  leftOpened () {
    this.$spacer.addClass('left-open');
  }

  leftClosed () {
    this.$spacer.removeClass('left-open');
  }

  rightOpened () {
    this.$spacer.addClass('right-open');
  }

  rightClosed () {
    this.$spacer.removeClass('right-open');
  }
}
