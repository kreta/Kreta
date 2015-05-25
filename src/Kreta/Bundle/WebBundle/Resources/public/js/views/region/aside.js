/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class AsideRegion extends Backbone.Marionette.Region {
  constructor(options) {
    this.position = options.position;
    this.el = '.' + this.position + '-aside';

    super(options);
  }

  onShow() {
    this.listenTo(Backbone, 'aside:before-open', this.hide);
    this.listenTo(Backbone, 'main:full-screen', this.hide);

    Backbone.trigger('aside:before-open');

    setTimeout(() => {
      this.$el.children().addClass('visible');
      Backbone.trigger(this.position + '-aside:after-open');
    }, 1);

  }

  hide () {
    if(this.$el.children().hasClass('visible')) {
      this.$el.children().removeClass('visible');
      Backbone.trigger(this.position + '-aside:close');

      setTimeout( () => { //Wait animation
        this.destroy();
      }, 500);
    }
  }
}
