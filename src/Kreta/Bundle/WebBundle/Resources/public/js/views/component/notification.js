/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class NotificationView extends Backbone.View {
  constructor(options) {
    this.className = 'notification ' + options.model.type;

    this.template = _.template($('#notification-template').html());

    this.$container = $('#kreta-content');

    this.events = {
      'click .notification-hide': 'hide'
    };

    super(options);
  }

  render() {
    this.$el.html(this.template(this.model));
    this.$container.prepend(this.el);

    return this;
  }

  show() {
    setTimeout(() => { //Wait until is added to the DOM to get the animation
      this.$el.addClass('visible');
    }, 10);

    setTimeout(() => {
      this.hide();
    }, 5000);
  }

  hide() {
    this.$el.removeClass('visible');
  }
}
