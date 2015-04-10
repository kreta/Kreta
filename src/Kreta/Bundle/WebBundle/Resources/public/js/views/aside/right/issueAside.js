/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Issue} from '../../../models/issue';

export class IssueAsideView extends Backbone.View {
  constructor (options) {
    this.className = 'issue-aside';

    this.template = _.template($('#issue-aside-template').html());

    this.events = {
      'click .issue-tab': 'tabClicked'
    };

    super();
    this.model = new Issue({id: options.id});
    this.model.fetch();

    this.model.on('sync', this.render, this);
  }

  render () {
    this.$el.html(this.template(this.model.toJSON()));

    this.$tabContent = this.$el.find('.issue-tab-content');

    return this;
  }

  tabClicked(ev) {
    var pos = $(ev.currentTarget).index();
    this.$tabContent.removeClass('visible');
    $(this.$tabContent.get(pos)).addClass('visible');

    return false;
  }
}
