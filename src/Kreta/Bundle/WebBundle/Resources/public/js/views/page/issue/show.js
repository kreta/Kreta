/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {AsideView} from '../../layout/aside';

export class IssueShowView extends AsideView {
  constructor (options) {
    this.className = 'full-issue-aside';

    this.template = _.template($('#issue-aside-template').html());

    this.events = {
      'click .full-issue-edit': 'editClicked',
      'click .full-issue-tab': 'tabClicked'
    };

    super(options);

    this.model.on('sync', this.render, this);

    Backbone.trigger('issue:highlight', this.model.id);
    this.render();

    this.$container.append(this.$el);
  }

  render () {
    this.$el.html(this.template(this.model.toJSON()));
    this.$footer = this.$el.find('footer');
    this.$tabContent = this.$footer.find('.full-issue-tab-content');

    return this;
  }

  tabClicked(ev) {
    var pos = $(ev.currentTarget).index();
    this.$tabContent.removeClass('visible');
    $(this.$tabContent.get(pos)).addClass('visible');

    return false;
  }

  editClicked() {
    App.router.navigate('/issue/' + this.model.id + '/edit');
    App.controller.issue.editAction(this.model);

    return false;
  }

  position() {
    return 'right';
  }
}
