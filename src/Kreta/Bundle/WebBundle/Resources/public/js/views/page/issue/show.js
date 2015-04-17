/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Issue} from '../../../models/issue';
import {CommentsTab} from './tabs/commentsTab';
import {AsideView} from '../../layout/aside';

export class IssueShowView extends AsideView {
  constructor (options) {
    this.className = 'issue-aside';

    this.template = _.template($('#issue-aside-template').html());

    this.events = {
      'click .issue-tab': 'tabClicked'
    };

    super();

    this.issueId = options.id;
    this.model = new Issue({id: options.id});
    this.model.fetch();
    this.model.on('sync', this.render, this);

    this.render();

    this.$container.append(this.$el);
  }

  render () {
    if(this.model.hasChanged()) {
      this.$el.html(this.template(this.model.toJSON()));
      this.$footer = this.$el.find('footer');

      var commentTab = new CommentsTab({issueId: this.issueId});
      this.$footer.append(commentTab.render().el);

      this.$tabContent = this.$footer.find('.issue-tab-content')

    } else {
      this.$el.html('Loading...');
    }

    return this;
  }

  tabClicked(ev) {
    var pos = $(ev.currentTarget).index();
    this.$tabContent.removeClass('visible');
    $(this.$tabContent.get(pos)).addClass('visible');

    return false;
  }

  position() {
    return 'right';
  }
}
