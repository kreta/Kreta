/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class NotificationView extends Backbone.Marionette.ItemView {
  constructor(options) {
    this.className = `notification ${options.model.type}`;
    this.template = '#notification-template';
    this.events = {
      'click .notification-hide': 'hide'
    };

    super(options);
  }

  serializeData() {
    return this.model;
  }

  show() {
    setTimeout(() => { // Wait until is added to the DOM to get the animation
      this.$el.addClass('visible');
    }, 50);

    setTimeout(() => {
      this.hide();
    }, 5000);
  }

  hide() {
    this.$el.removeClass('visible');

    setTimeout(() => {
      this.destroy();
    }, 550); // Wait animation
  }
}
