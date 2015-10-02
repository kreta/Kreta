/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class IssueShowView extends Backbone.Marionette.ItemView {
  constructor(options = {}) {
    _.defaults(options, {
      className: 'full-issue-aside spacer-2',
      template: '#issue-show-template',
      events: {
        'click .full-issue-tab': 'tabClicked',
        'click .full-issue-transition': 'doTransition'
      }
    });
    super(options);

    this.model.on('change', this.render, this);
    App.vent.trigger('issue:highlight', this.model.id);
  }

  ui() {
    return {
      'tabContent': '.full-issue-tab-content',
      'transitions': '.full-issue-transitions'
    };
  }

  serializeData() {
    var data = this.model.toJSON();

    data.transitions = this.model.getAllowedTransitions();
    data.canEdit = this.model.canEdit(App.currentUser);

    return data;
  }

  tabClicked(ev) {
    var pos = $(ev.currentTarget).index();

    this.ui.tabContent.removeClass('visible');
    $(this.ui.tabContent.get(pos)).addClass('visible');

    return false;
  }

  doTransition(ev) {
    this.ui.transitions.hide();
    this.model.doTransition($($(ev)[0].currentTarget).attr('data-transition'), {
      success: (data) => {
        this.model.set(data);
        App.vent.trigger('issue:updated', data);
      }
    });

    return false;
  }
}
