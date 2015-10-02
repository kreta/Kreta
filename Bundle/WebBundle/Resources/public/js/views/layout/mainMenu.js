/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class HeaderView extends Backbone.View {
  constructor(options = {}) {
    _.defaults(options, {
      el: '.menu',
      events: {
        'click .menu-action.projects': 'showProjectList'
      }
    });
    super(options);
    this.$userInfo = $('.menu-user');
    this.userInfoTemplate = _.template($('#kreta-menu-user-template').html());
    this.listenTo(App.currentUser, 'change', this.render);
    Mousetrap.bind('p', () => {
      App.controller.project.listAction();
    });
    this.render();
  }

  render() {
    if (App.currentUser.get('id')) {
      this.$userInfo.html(this.userInfoTemplate(App.currentUser.toJSON()));
    }
  }

  showProjectList() {
    App.controller.project.listAction();

    return false;
  }
}
