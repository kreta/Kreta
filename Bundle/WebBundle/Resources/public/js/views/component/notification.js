/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import Style from '../../../scss/components/_notification.scss';

export class NotificationView {
  constructor(options = {}) {
    _.defaults(options, {
      className: `notification ${options.model.type}`,
      template: '#notification-template',
      events: {
        'click .notification-hide': 'hide'
      }
    });
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
