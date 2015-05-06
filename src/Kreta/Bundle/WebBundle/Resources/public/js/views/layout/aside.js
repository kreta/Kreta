/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class AsideView extends Backbone.View {
  constructor () {
    super();

    this.$container = $('#kreta-' + this.position() + '-aside');

    this.listenTo(Backbone, 'aside:before-open', this.hide);
    this.listenTo(Backbone, 'main:full-screen', this.hide);
  }

  hide () {
    if(this.$el.hasClass('visible')) {
      this.$el.removeClass('visible');
      Backbone.trigger(this.position() + '-aside:close');

      setTimeout( () => { //Wait animation
        this.undelegateEvents();
        this.$el.removeData().unbind();
        this.remove();
      }, 500);
    }
  }

  show () {
    Backbone.trigger('aside:before-open');

    setTimeout(() => {
      this.$el.addClass('visible');
      Backbone.trigger(this.position() + '-aside:after-open');
    }, 1);
  }

  position() {
    return 'left';
  }
}
