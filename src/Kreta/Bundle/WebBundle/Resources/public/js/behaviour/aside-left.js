/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class AsideLeftBehaviour extends Backbone.Marionette.Behaviour {
  onBeforeDestroy () {
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

  onShow () {
    Backbone.trigger('aside:before-open');

    setTimeout(() => {
      this.$el.addClass('visible');
      Backbone.trigger(this.position() + '-aside:after-open');
    }, 1);
  }
}
